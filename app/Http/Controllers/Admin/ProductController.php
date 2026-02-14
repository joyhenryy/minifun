<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'images'])->latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'additional_images' => 'nullable|array|max:10',
            'additional_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'shopee_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'variants' => 'nullable|array',
            'variants.*.type' => 'required_with:variants|string|max:50',
            'variants.*.name' => 'required_with:variants|string|max:100',
            'variants.*.price_adjustment' => 'nullable|numeric',
            'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        unset($validated['image'], $validated['additional_images']);
        $product = Product::create($validated);

        // Store additional images
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $index => $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('products', 'public');
                    $product->images()->create([
                        'image_path' => $path,
                        'sort_order' => $index + 1,
                    ]);
                }
            }
        }

        // Store variants
        if ($request->has('variants')) {
            foreach ($request->variants as $index => $variantData) {
                if (!empty($variantData['type']) && !empty($variantData['name'])) {
                    $newVariant = [
                        'product_id' => $product->id,
                        'type' => $variantData['type'],
                        'name' => $variantData['name'],
                        'price_adjustment' => $variantData['price_adjustment'] ?? 0,
                    ];

                    if ($request->hasFile("variants.$index.image")) {
                        $newVariant['image_path'] = $request->file("variants.$index.image")->store('variants', 'public');
                    }

                    $product->variants()->create($newVariant);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::all();
        return view('admin.products.form', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'additional_images' => 'nullable|array|max:10',
            'additional_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'shopee_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'variants' => 'nullable|array',
            'variants.*.type' => 'required_with:variants|string|max:50',
            'variants.*.name' => 'required_with:variants|string|max:100',
            'variants.*.price_adjustment' => 'nullable|numeric',
            'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        // Delete selected additional images
        if ($request->filled('delete_images')) {
            $deleteIds = $request->input('delete_images');
            $imagesToDelete = ProductImage::where('product_id', $product->id)
                ->whereIn('id', $deleteIds)
                ->get();

            foreach ($imagesToDelete as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        // Add new additional images
        if ($request->hasFile('additional_images')) {
            $maxOrder = $product->images()->max('sort_order') ?? 0;
            foreach ($request->file('additional_images') as $index => $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('products', 'public');
                    $product->images()->create([
                        'image_path' => $path,
                        'sort_order' => $maxOrder + $index + 1,
                    ]);
                }
            }
        }

        // Sync Variants
        DB::transaction(function () use ($product, $request) {
            $inputVariants = $request->input('variants', []);
            Log::info('Updating product variants', ['product_id' => $product->id, 'input_variants' => $inputVariants, 'files' => $request->allFiles()]);

            $submittedVariantIds = [];

            // 1. Collect IDs that are being kept
            foreach ($inputVariants as $data) {
                if (isset($data['id'])) {
                    $submittedVariantIds[] = $data['id'];
                }
            }

            // 2. Delete non-submitted variants (this handles deletions)
            $variantsToDelete = $product->variants()->whereNotIn('id', $submittedVariantIds)->get();
            foreach ($variantsToDelete as $v) {
                if ($v->image_path) {
                    Storage::disk('public')->delete($v->image_path);
                }
                $v->delete();
            }

            // 3. Update or Create variants
            foreach ($inputVariants as $index => $variantData) {
                // Basic validation check
                if (empty($variantData['type']) || empty($variantData['name'])) {
                    continue;
                }

                $attributes = [
                    'product_id' => $product->id,
                    'type' => $variantData['type'],
                    'name' => $variantData['name'],
                    'price_adjustment' => $variantData['price_adjustment'] ?? 0,
                ];

                // Handle Image Upload
                if ($request->hasFile("variants.{$index}.image")) {
                    Log::info("Uploading image for variant index $index");
                    // If updating an existing variant, clean up old image
                    if (!empty($variantData['id'])) {
                        $oldVariant = $product->variants()->find($variantData['id']);
                        if ($oldVariant && $oldVariant->image_path) {
                            Storage::disk('public')->delete($oldVariant->image_path);
                        }
                    }
                    $attributes['image_path'] = $request->file("variants.{$index}.image")->store('variants', 'public');
                }

                $product->variants()->updateOrCreate(
                    ['id' => $variantData['id'] ?? null],
                    $attributes
                );
            }
        });

        unset($validated['image'], $validated['additional_images']);
        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        // Delete additional images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
