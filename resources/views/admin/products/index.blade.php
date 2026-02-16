@extends('layouts.admin')

@section('page_title', 'Products')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">All Products</h2>
        <p class="text-sm text-gray-400 mt-0.5">Manage your product catalog</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-black hover:bg-gray-800 text-white text-sm font-semibold rounded-xl transition-all duration-300">
        <i class="fas fa-plus"></i> Add Product
    </a>
</div>

{{-- Products Table --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Product</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Category</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Price</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-xl object-cover bg-gray-100 border border-gray-100">
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $product->name }}</div>
                                    {{-- <div class="text-xs text-gray-400 mt-0.5">{{ Str::limit($product->description, 40) }}</div> --}}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-medium">{{ $product->category->name ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $product->formatted_price }}</td>
                        <td class="px-6 py-4">
                            @if($product->is_featured)
                                <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-semibold"><i class="fas fa-star mr-1 text-[10px]"></i>Featured</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-gray-50 text-gray-400 text-xs font-medium">Standard</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200" title="Edit">
                                    <i class="fas fa-pen text-xs"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200" title="Delete">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-car text-xl text-gray-300"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900">No products yet</h3>
                            <p class="text-gray-400 text-sm mt-1">Get started by adding your first product.</p>
                            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-black text-white text-sm font-semibold rounded-xl hover:bg-gray-800 transition-colors">
                                <i class="fas fa-plus"></i> Add Product
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
    @endif
</div>

@endsection
