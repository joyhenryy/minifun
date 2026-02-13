@extends('layouts.admin')

@section('page_title', isset($product) ? 'Edit Product' : 'Add Product')

@section('content')

<div class="max-w-3xl">
    {{-- Back --}}
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-gray-900 mb-6 transition-colors">
        <i class="fas fa-arrow-left"></i> Back to Products
    </a>

    <div class="bg-white rounded-2xl border border-gray-100 p-6 lg:p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">{{ isset($product) ? 'Edit Product' : 'New Product' }}</h2>

        @if($errors->any())
            <div class="mb-6 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ isset($product) ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if(isset($product))
                @method('PUT')
            @endif

            {{-- Name --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Product Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm transition-all duration-300" placeholder="e.g. Hot Wheels 2024 Mustang GT">
            </div>

            {{-- Category & Price Row --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Category</label>
                    <select name="category_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm transition-all duration-300">
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Price (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" required min="0" step="100" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm transition-all duration-300" placeholder="85000">
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Description</label>
                <textarea name="description" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm transition-all duration-300 resize-none" placeholder="Describe your product...">{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            {{-- Main Image Upload --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Main Product Image</label>
                @if(isset($product) && $product->image_path)
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-20 h-20 rounded-xl object-cover border border-gray-200">
                        <span class="text-xs text-gray-400">Current main image</span>
                    </div>
                @endif
                <div class="relative">
                    <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" id="image-input" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm transition-all duration-300 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-600 hover:file:bg-amber-100">
                </div>
                <p class="text-xs text-gray-400 mt-1">JPG, PNG or WebP. Max 2MB. This will be the primary cover image.</p>
            </div>

            {{-- Additional Images Upload --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                    Additional Images <span class="text-gray-400 normal-case">(Gallery / Carousel)</span>
                </label>

                @if(isset($product) && $product->images->count() > 0)
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-2">Current additional images (check to delete):</p>
                        <div class="grid grid-cols-4 sm:grid-cols-6 gap-3">
                            @foreach($product->images as $img)
                                <label class="relative group cursor-pointer">
                                    <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="absolute top-2 right-2 z-10 w-4 h-4 rounded border-gray-300 text-red-500 focus:ring-red-500/20 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <img src="{{ $img->image_url }}" alt="Additional image" class="w-full aspect-square rounded-lg object-cover border border-gray-200 group-hover:border-red-300 group-hover:opacity-75 transition-all">
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="text-[10px] font-semibold text-red-500 bg-white/90 px-2 py-0.5 rounded-md">Remove</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div id="additional-images-container" class="space-y-3">
                    {{-- Default first input --}}
                    <div class="flex items-center gap-2">
                        <input type="file" name="additional_images[]" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-black file:text-white hover:file:bg-gray-800 transition-colors">
                        <button type="button" class="hidden text-red-500 hover:text-red-700" onclick="removeInput(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <button type="button" onclick="addInfoImageInput()" class="mt-3 inline-flex items-center gap-2 text-xs font-bold text-amber-600 hover:text-amber-700">
                    <i class="fas fa-plus-circle"></i> Add Another Image
                </button>
                <p class="text-xs text-gray-400 mt-2">Add as many images as you like for the gallery (Max 2MB each).</p>
            </div>

            <script>
                function addInfoImageInput() {
                    const container = document.getElementById('additional-images-container');
                    const div = document.createElement('div');
                    div.className = 'flex items-center gap-2';
                    div.innerHTML = `
                        <input type="file" name="additional_images[]" accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-black file:text-white hover:file:bg-gray-800 transition-colors">
                        <button type="button" class="text-red-500 hover:text-red-700 p-2" onclick="removeInput(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                    container.appendChild(div);
                }

                function removeInput(btn) {
                    btn.closest('div').remove();
                }
            </script>

            {{-- Shopee URL --}}
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Shopee URL</label>
                <input type="url" name="shopee_url" value="{{ old('shopee_url', $product->shopee_url ?? '') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm transition-all duration-300" placeholder="https://shopee.co.id/product/...">
            </div>

            {{-- Featured Toggle --}}
            <div class="flex items-center gap-3 p-4 rounded-xl bg-amber-50 border border-amber-100">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-amber-500 focus:ring-amber-500/20">
                <label for="is_featured" class="cursor-pointer">
                    <span class="text-sm font-semibold text-gray-900">Featured Product</span>
                    <p class="text-xs text-gray-500">This product will be highlighted on the home page.</p>
                </label>
            </div>

            {{-- Submit --}}
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <button type="submit" class="px-8 py-3 bg-black hover:bg-gray-800 text-white text-sm font-bold rounded-xl transition-all duration-300 hover:scale-[1.02]">
                    {{ isset($product) ? 'Update Product' : 'Create Product' }}
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-xl transition-all duration-300">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
