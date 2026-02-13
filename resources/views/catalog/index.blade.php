@extends('layouts.app')

@section('title', 'Catalog')
@section('meta_description', 'Browse the full MINIFUN diecast collection. Filter by category and find your next favorite collectible.')

@section('content')

{{-- Page Header --}}
<section class="bg-black text-white py-16 lg:py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-72 h-72 bg-amber-500 rounded-full blur-[120px]"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <span class="text-xs font-semibold uppercase tracking-wider text-amber-500">Our Collection</span>
        <h1 class="mt-2 text-4xl sm:text-5xl font-black tracking-tight">Product Catalog</h1>
        <p class="mt-3 text-gray-400 max-w-xl">Explore our full range of premium diecast models from top brands worldwide.</p>
    </div>
</section>

<section class="py-10 lg:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Filters Bar --}}
        <div class="mb-10 flex flex-col lg:flex-row items-start lg:items-center gap-4">
            {{-- Search --}}
            <form action="{{ route('catalog.index') }}" method="GET" class="flex-1 w-full lg:max-w-md">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm transition-all duration-300">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                </div>
            </form>

            {{-- Category Chips --}}
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('catalog.index', request()->only('search')) }}" class="px-4 py-2 rounded-full text-xs font-semibold transition-all duration-300 {{ !request('category') ? 'bg-black text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    All
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('catalog.index', array_merge(request()->only('search'), ['category' => $category->slug])) }}" class="px-4 py-2 rounded-full text-xs font-semibold transition-all duration-300 {{ request('category') === $category->slug ? 'bg-black text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ $category->name }} <span class="text-gray-400 ml-1">({{ $category->products_count }})</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Active Filters --}}
        @if(request('search') || request('category'))
            <div class="mb-6 flex items-center gap-2 text-sm text-gray-500">
                <span>Showing results</span>
                @if(request('search'))
                    <span>for "<strong class="text-black">{{ request('search') }}</strong>"</span>
                @endif
                @if(request('category'))
                    <span>in <strong class="text-black">{{ request('category') }}</strong></span>
                @endif
                <a href="{{ route('catalog.index') }}" class="ml-2 text-red-500 hover:text-red-700 text-xs font-medium">
                    <i class="fas fa-times"></i> Clear
                </a>
            </div>
        @endif

        {{-- Product Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                <a href="{{ route('catalog.show', $product->slug) }}" class="group block bg-white rounded-2xl border border-gray-100 hover:border-gray-200 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:shadow-black/5 hover:-translate-y-1">
                    {{-- Image --}}
                    <div class="relative aspect-square bg-gray-50 overflow-hidden">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                        @if($product->is_featured)
                            <div class="absolute top-3 left-3 px-2.5 py-1 bg-amber-500 text-black text-xs font-bold rounded-lg">
                                <i class="fas fa-star mr-1"></i> Featured
                            </div>
                        @endif
                    </div>
                    {{-- Info --}}
                    <div class="p-5">
                        <div class="text-xs font-medium text-amber-600 mb-1">{{ $product->category->name ?? 'Uncategorized' }}</div>
                        <h3 class="font-bold text-gray-900 group-hover:text-amber-600 transition-colors line-clamp-2">{{ $product->name }}</h3>
                        <p class="mt-1.5 text-xs text-gray-400 line-clamp-2">{{ $product->description }}</p>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-lg font-black text-black">{{ $product->formatted_price }}</span>
                            <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 group-hover:bg-amber-500 group-hover:text-black text-gray-400 transition-all duration-300 text-xs">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-20">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-search text-2xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">No Products Found</h3>
                    <p class="text-gray-500 text-sm mt-1">Try adjusting your search or filter criteria.</p>
                    <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 mt-4 text-sm text-amber-500 hover:text-amber-600 font-medium">
                        <i class="fas fa-arrow-left"></i> View All Products
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</section>

@endsection
