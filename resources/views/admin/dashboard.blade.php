@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')

{{-- Stats Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-6 hover:shadow-lg hover:shadow-black/5 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total Products</p>
                <p class="mt-2 text-3xl font-black text-black">{{ $stats['totalProducts'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center">
                <i class="fas fa-car text-amber-500"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-6 hover:shadow-lg hover:shadow-black/5 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Categories</p>
                <p class="mt-2 text-3xl font-black text-black">{{ $stats['totalCategories'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center">
                <i class="fas fa-tags text-blue-500"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-6 hover:shadow-lg hover:shadow-black/5 transition-all duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Featured</p>
                <p class="mt-2 text-3xl font-black text-black">{{ $stats['featuredProducts'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-yellow-50 flex items-center justify-center">
                <i class="fas fa-star text-yellow-500"></i>
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="flex flex-wrap gap-3 mb-8">
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-black hover:bg-gray-800 text-white text-sm font-semibold rounded-xl transition-all duration-300">
        <i class="fas fa-plus"></i> New Product
    </a>
    <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition-all duration-300">
        <i class="fas fa-plus"></i> New Category
    </a>
</div>

{{-- Recent Products --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-bold text-gray-900">Recent Products</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Product</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Category</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Price</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recentProducts as $product)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-10 h-10 rounded-lg object-cover bg-gray-100">
                                <span class="font-medium text-gray-900">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-medium">{{ $product->category->name ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $product->formatted_price }}</td>
                        <td class="px-6 py-4">
                            @if($product->is_featured)
                                <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-semibold">Featured</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-gray-50 text-gray-400 text-xs font-medium">Standard</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-400 text-xs">{{ $product->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">No products yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
