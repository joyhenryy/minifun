@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', Str::limit($product->description, 155))

@section('content')

{{-- Breadcrumb --}}
<div class="bg-gray-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-black transition-colors">Home</a>
            <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            <a href="{{ route('catalog.index') }}" class="hover:text-black transition-colors">Catalog</a>
            <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="hover:text-black transition-colors">{{ $product->category->name }}</a>
            <i class="fas fa-chevron-right text-[10px] text-gray-300"></i>
            <span class="text-black font-medium truncate max-w-[200px]">{{ $product->name }}</span>
        </nav>
    </div>
</div>

{{-- Product Detail --}}
<section class="py-12 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16">

            {{-- Product Image --}}
            <div class="relative">
                <div class="aspect-square rounded-3xl overflow-hidden bg-gray-50 border border-gray-100">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-700">
                </div>
                @if($product->is_featured)
                    <div class="absolute top-4 left-4 px-3 py-1.5 bg-amber-500 text-black text-xs font-bold rounded-xl shadow-lg shadow-amber-500/25">
                        <i class="fas fa-star mr-1"></i> Featured
                    </div>
                @endif
            </div>

            {{-- Product Info --}}
            <div class="flex flex-col justify-center">
                {{-- Category Badge --}}
                <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-50 text-amber-600 text-xs font-semibold w-fit hover:bg-amber-100 transition-colors">
                    <i class="fas fa-tag text-[10px]"></i>
                    {{ $product->category->name }}
                </a>

                {{-- Name --}}
                <h1 class="mt-4 text-3xl sm:text-4xl font-black text-black tracking-tight leading-tight">{{ $product->name }}</h1>

                {{-- Price --}}
                <div class="mt-4 flex items-center gap-3">
                    <span class="text-3xl sm:text-4xl font-black text-black">{{ $product->formatted_price }}</span>
                </div>

                {{-- Divider --}}
                <div class="my-6 border-t border-gray-100"></div>

                {{-- Description --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3">Description</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $product->description ?: 'No description available.' }}</p>
                </div>

                {{-- Specs --}}
                <div class="mt-6 grid grid-cols-2 gap-3">
                    <div class="px-4 py-3 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="text-xs text-gray-400 font-medium">Category</div>
                        <div class="text-sm font-semibold text-gray-900 mt-0.5">{{ $product->category->name }}</div>
                    </div>
                    <div class="px-4 py-3 rounded-xl bg-gray-50 border border-gray-100">
                        <div class="text-xs text-gray-400 font-medium">Status</div>
                        <div class="text-sm font-semibold text-green-600 mt-0.5"><i class="fas fa-circle text-[6px] mr-1"></i> Available</div>
                    </div>
                </div>

                {{-- CTA Buttons --}}
                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    @if($product->shopee_url)
                        <a href="{{ $product->shopee_url }}" target="_blank" rel="noopener noreferrer" class="flex-1 inline-flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-orange-500 to-red-500 text-white font-bold text-sm rounded-xl transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-orange-500/25">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                            </svg>
                            <span>Buy on Shopee</span>
                        </a>
                    @endif
                    <a href="{{ $product->whatsapp_url }}" target="_blank" rel="noopener noreferrer" class="flex-1 inline-flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-green-600 to-green-500 text-white font-bold text-sm rounded-xl transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-green-500/25">
                        <i class="fab fa-whatsapp text-lg"></i>
                        <span>Product Inquiry</span>
                    </a>
                </div>

                <p class="mt-3 text-xs text-gray-400 text-center sm:text-left">
                    <i class="fas fa-shield-alt mr-1"></i> 100% Authentic Product Guarantee
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Related Products --}}
@if($relatedProducts->isNotEmpty())
<section class="py-16 lg:py-24 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-amber-500">You Might Also Like</span>
                <h2 class="mt-2 text-2xl sm:text-3xl font-black text-black tracking-tight">Related Products</h2>
            </div>
            <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="text-sm font-medium text-gray-500 hover:text-black transition-colors">
                View More <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
                <a href="{{ route('catalog.show', $related->slug) }}" class="group block bg-white rounded-2xl border border-gray-100 hover:border-gray-200 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:shadow-black/5 hover:-translate-y-1">
                    <div class="relative aspect-square bg-gray-50 overflow-hidden">
                        <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" loading="lazy">
                    </div>
                    <div class="p-5">
                        <div class="text-xs font-medium text-amber-600 mb-1">{{ $related->category->name }}</div>
                        <h3 class="font-bold text-gray-900 group-hover:text-amber-600 transition-colors line-clamp-2">{{ $related->name }}</h3>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-lg font-black text-black">{{ $related->formatted_price }}</span>
                            <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 group-hover:bg-amber-500 group-hover:text-black text-gray-400 transition-all duration-300 text-xs">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
