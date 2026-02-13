<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
