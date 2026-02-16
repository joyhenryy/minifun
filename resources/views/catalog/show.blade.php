@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', Str::limit($product->description, 155))

@section('content')

@php $imageUrls = $product->all_image_urls; @endphp

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

            {{-- Product Image Gallery --}}
            <div class="relative" id="product-gallery">
                {{-- Main Image Display --}}
                <div class="relative aspect-square rounded-3xl overflow-hidden bg-gray-50 border border-gray-100 group">
                    @foreach($imageUrls as $index => $url)
                        <img
                            src="{{ $url }}"
                            alt="{{ $product->name }} - Image {{ $index + 1 }}"
                            class="absolute inset-0 w-full h-full object-cover transition-all duration-500 ease-in-out cursor-zoom-in {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                            data-gallery-index="{{ $index }}"
                            onclick="openLightbox({{ $index }})"
                        >
                    @endforeach

                    {{-- Navigation Arrows --}}
                    @if(count($imageUrls) > 1)
                        <button class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:bg-white hover:text-black shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110" onclick="galleryNav(-1)">
                            <i class="fas fa-chevron-left text-sm"></i>
                        </button>
                        <button class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:bg-white hover:text-black shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110" onclick="galleryNav(1)">
                            <i class="fas fa-chevron-right text-sm"></i>
                        </button>

                        {{-- Image Counter --}}
                        <div class="absolute right-4 top-4 z-20 px-3 py-1.5 rounded-xl bg-black/40 backdrop-blur-sm text-white text-xs font-semibold">
                            <i class="fas fa-images mr-1"></i>
                            <span id="gallery-counter">1</span>/{{ count($imageUrls) }}
                        </div>
                    @endif

                    @if($product->is_featured)
                        <div class="absolute top-4 left-4 z-20 px-3 py-1.5 bg-yellow-500/80 backdrop-blur-sm text-white text-xs font-bold rounded-xl shadow-lg shadow-amber-500/25">
                            <i class="fas fa-star mr-1"></i> Featured
                        </div>
                    @endif
                </div>

                {{-- Thumbnail Strip --}}
                @if(count($imageUrls) > 1)
                    <div class="mt-4 flex gap-3 overflow-x-auto pb-2 scrollbar-hide" id="thumbnail-strip">
                        @foreach($imageUrls as $index => $url)
                            <button
                                class="flex-shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden border-2 transition-all duration-300 hover:scale-105 {{ $index === 0 ? 'border-amber-500 ring-2 ring-amber-500/20' : 'border-gray-200 hover:border-gray-300' }}"
                                data-thumb-index="{{ $index }}"
                                onclick="galleryGoTo({{ $index }})"
                            >
                                <img src="{{ $url }}" alt="Thumbnail {{ $index + 1 }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
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
                <h1 class="mt-4 text-3xl sm:text-4xl font-semibold text-black tracking-tight leading-tight">{{ $product->name }}</h1>

                {{-- Price --}}
                <div class="mt-4 flex items-center gap-3">
                    <span class="text-3xl sm:text-4xl font-extrabold text-black">{{ $product->formatted_price }}</span>
                </div>

                {{-- Divider --}}
                <div class="my-6 border-t border-gray-100"></div>

                {{-- Description --}}
                {{-- Description --}}
                <div class="relative">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3">Description</h3>
                    <div id="description-container" class="relative overflow-hidden transition-all duration-500 max-h-[120px]">
                        <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $product->description ?: 'No description available.' }}</p>
                        <div id="description-overlay" class="absolute bottom-0 left-0 w-full h-12 bg-gradient-to-t from-white to-transparent"></div>
                    </div>
                    <button id="toggle-description-btn" class="mt-2 text-sm font-semibold text-amber-600 hover:text-amber-700 flex items-center gap-1 transition-colors hidden" onclick="toggleDescription()">
                        <span>View More</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                    </button>
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
                    @if(count($imageUrls) > 1)
                    <div class="px-4 py-3 rounded-xl bg-gray-50 border border-gray-100 col-span-2">
                        <div class="text-xs text-gray-400 font-medium">Photos</div>
                        <div class="text-sm font-semibold text-gray-900 mt-0.5"><i class="fas fa-images text-amber-500 mr-1"></i> {{ count($imageUrls) }} images available</div>
                    </div>
                    @endif
                </div>

                {{-- Variants Display --}}
                @if($product->variants->isNotEmpty())
                    <div class="mt-6">
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3">Available Variations</h3>
                        <div class="space-y-4">
                            @foreach($product->variants->groupBy('type') as $type => $variants)
                                <div>
                                    <span class="text-xs font-medium text-gray-500 mb-2 block">{{ $type }}</span>
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($variants as $variant)
                                            <button 
                                                type="button"
                                                class="variant-btn group relative flex items-center gap-3 px-3 py-2 rounded-lg border-2 border-gray-200 bg-white hover:border-amber-500 transition-all min-w-[120px]"
                                                data-type="{{ $type }}"
                                                data-price-diff="{{ $variant->price_adjustment }}"
                                                data-image="{{ $variant->image_url }}"
                                                onclick="selectVariant(this)"
                                            >
                                                {{-- Thumbnail --}}
                                                @if($variant->image_path)
                                                    <img src="{{ $variant->image_url }}" alt="{{ $variant->name }}" class="w-10 h-10 rounded-md object-cover bg-gray-50 border border-gray-100">
                                                @endif

                                                {{-- Text Info --}}
                                                <div class="flex flex-col items-start {{ !$variant->image_path ? 'w-full text-center items-center' : '' }}">
                                                    <span class="text-xs font-bold text-gray-900 group-hover:text-amber-600">{{ $variant->name }}</span>
                                                    @if($variant->price_adjustment != 0)
                                                        <span class="text-[10px] font-medium {{ $variant->price_adjustment > 0 ? 'text-green-600' : 'text-red-500' }}">
                                                            {{ $variant->price_adjustment > 0 ? '+' : '' }}Rp{{ number_format($variant->price_adjustment / 1000, 0) }}k
                                                        </span>
                                                    @endif
                                                </div>

                                                {{-- Active Checkmark (Triangle) --}}
                                                <div class="active-check hidden absolute bottom-0 right-0">
                                                    <div class="w-0 h-0 border-b-[24px] border-b-amber-500 border-l-[24px] border-l-transparent rounded-br-lg"></div>
                                                    <i class="fas fa-check text-[8px] text-white absolute bottom-[3px] right-[3px]"></i>
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

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

{{-- Lightbox Modal --}}
<div id="lightbox" class="fixed inset-0 z-50 hidden bg-black/95 backdrop-blur-lg" onclick="closeLightbox(event)">
    <button class="absolute top-6 right-6 z-50 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-all duration-300 hover:scale-110" onclick="closeLightbox(event, true)">
        <i class="fas fa-times text-lg"></i>
    </button>

    <div class="absolute inset-0 flex items-center justify-center p-4 sm:p-12">
        @foreach($imageUrls as $index => $url)
            <img
                src="{{ $url }}"
                alt="{{ $product->name }} - Image {{ $index + 1 }}"
                class="max-w-full max-h-full object-contain transition-all duration-500 ease-in-out absolute {{ $index === 0 ? 'opacity-100 scale-100' : 'opacity-0 scale-95' }}"
                data-lightbox-index="{{ $index }}"
                onclick="event.stopPropagation()"
            >
        @endforeach
    </div>

    @if(count($imageUrls) > 1)
        <button class="absolute left-4 sm:left-8 top-1/2 -translate-y-1/2 z-50 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110" onclick="event.stopPropagation(); lightboxNav(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="absolute right-4 sm:right-8 top-1/2 -translate-y-1/2 z-50 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-all duration-300 hover:scale-110" onclick="event.stopPropagation(); lightboxNav(1)">
            <i class="fas fa-chevron-right"></i>
        </button>

        {{-- Lightbox Bottom Counter --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-50 flex items-center gap-3">
            @foreach($imageUrls as $index => $url)
                <button
                    class="lightbox-dot w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-white scale-125' : 'bg-white/40 hover:bg-white/60' }}"
                    data-lightbox-dot="{{ $index }}"
                    onclick="event.stopPropagation(); lightboxGoTo({{ $index }})"
                ></button>
            @endforeach
        </div>
    @endif
</div>

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
                @php $relatedImageUrls = $related->all_image_urls; @endphp
                <div class="group block bg-white rounded-2xl border border-gray-100 hover:border-gray-200 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:shadow-black/5 hover:-translate-y-1">
                    <div class="relative aspect-square bg-gray-50 overflow-hidden product-carousel" data-product-id="related-{{ $related->id }}">
                        @foreach($relatedImageUrls as $index => $url)
                            <img
                                src="{{ $url }}"
                                alt="{{ $related->name }} - Image {{ $index + 1 }}"
                                class="absolute inset-0 w-full h-full object-cover transition-all duration-500 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                                data-slide-index="{{ $index }}"
                                loading="lazy"
                            >
                        @endforeach

                        @if(count($relatedImageUrls) > 1)
                            <button class="absolute left-2 top-1/2 -translate-y-1/2 z-20 w-7 h-7 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:bg-white hover:text-black shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300" onclick="event.preventDefault(); event.stopPropagation(); carouselNav('related-{{ $related->id }}', -1)">
                                <i class="fas fa-chevron-left text-[10px]"></i>
                            </button>
                            <button class="absolute right-2 top-1/2 -translate-y-1/2 z-20 w-7 h-7 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:bg-white hover:text-black shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300" onclick="event.preventDefault(); event.stopPropagation(); carouselNav('related-{{ $related->id }}', 1)">
                                <i class="fas fa-chevron-right text-[10px]"></i>
                            </button>

                            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1.5 px-2 py-1 rounded-full bg-black/30 backdrop-blur-sm">
                                @foreach($relatedImageUrls as $dotIndex => $url)
                                    <button class="carousel-dot w-1.5 h-1.5 rounded-full transition-all duration-300 {{ $dotIndex === 0 ? 'bg-white w-3' : 'bg-white/50' }}" data-dot-index="{{ $dotIndex }}" onclick="event.preventDefault(); event.stopPropagation(); carouselGoTo('related-{{ $related->id }}', {{ $dotIndex }})"></button>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('catalog.show', $related->slug) }}" class="block p-5">
                        <div class="text-xs font-medium text-amber-600 mb-1">{{ $related->category->name }}</div>
                        <h3 class="font-bold text-gray-900 group-hover:text-amber-600 transition-colors line-clamp-2">{{ $related->name }}</h3>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-lg font-black text-black">{{ $related->formatted_price }}</span>
                            <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 group-hover:bg-amber-500 group-hover:text-black text-gray-400 transition-all duration-300 text-xs">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Gallery & Lightbox JavaScript --}}
<script>
    // ── Product Detail Gallery ──────────────────────────
    let currentGalleryIndex = 0;
    const totalGalleryImages = {{ count($imageUrls) }};

    function galleryGoTo(index) {
        if (index < 0) index = totalGalleryImages - 1;
        if (index >= totalGalleryImages) index = 0;
        currentGalleryIndex = index;

        // Update main images
        document.querySelectorAll('[data-gallery-index]').forEach((img, i) => {
            if (i === index) {
                img.classList.remove('opacity-0', 'z-0');
                img.classList.add('opacity-100', 'z-10');
            } else {
                img.classList.remove('opacity-100', 'z-10');
                img.classList.add('opacity-0', 'z-0');
            }
        });

        // Update thumbnails
        document.querySelectorAll('[data-thumb-index]').forEach((thumb, i) => {
            if (i === index) {
                thumb.classList.remove('border-gray-200', 'hover:border-gray-300');
                thumb.classList.add('border-amber-500', 'ring-2', 'ring-amber-500/20');
            } else {
                thumb.classList.remove('border-amber-500', 'ring-2', 'ring-amber-500/20');
                thumb.classList.add('border-gray-200', 'hover:border-gray-300');
            }
        });

        // Update counter
        const counter = document.getElementById('gallery-counter');
        if (counter) counter.textContent = index + 1;

        // Scroll thumbnail into view
        const thumbStrip = document.getElementById('thumbnail-strip');
        const activeThumb = document.querySelector(`[data-thumb-index="${index}"]`);
        if (thumbStrip && activeThumb) {
            activeThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    }

    function galleryNav(direction) {
        galleryGoTo(currentGalleryIndex + direction);
    }

    // ── Lightbox ────────────────────────────────────────
    let currentLightboxIndex = 0;

    function openLightbox(index) {
        const lightbox = document.getElementById('lightbox');
        lightbox.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        lightboxGoTo(index);
    }

    function closeLightbox(event, force = false) {
        if (force || event.target.id === 'lightbox') {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    function lightboxGoTo(index) {
        if (index < 0) index = totalGalleryImages - 1;
        if (index >= totalGalleryImages) index = 0;
        currentLightboxIndex = index;

        document.querySelectorAll('[data-lightbox-index]').forEach((img, i) => {
            if (i === index) {
                img.classList.remove('opacity-0', 'scale-95');
                img.classList.add('opacity-100', 'scale-100');
            } else {
                img.classList.remove('opacity-100', 'scale-100');
                img.classList.add('opacity-0', 'scale-95');
            }
        });

        document.querySelectorAll('[data-lightbox-dot]').forEach((dot, i) => {
            if (i === index) {
                dot.classList.remove('bg-white/40', 'hover:bg-white/60');
                dot.classList.add('bg-white', 'scale-125');
            } else {
                dot.classList.remove('bg-white', 'scale-125');
                dot.classList.add('bg-white/40', 'hover:bg-white/60');
            }
        });
    }

    function lightboxNav(direction) {
        lightboxGoTo(currentLightboxIndex + direction);
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        const lightbox = document.getElementById('lightbox');
        if (!lightbox.classList.contains('hidden')) {
            if (e.key === 'ArrowLeft') lightboxNav(-1);
            if (e.key === 'ArrowRight') lightboxNav(1);
            if (e.key === 'Escape') { lightbox.classList.add('hidden'); document.body.style.overflow = ''; }
        }
    });

    // ── Related Products Carousel ───────────────────────
    const carouselState = {};

    function getCarouselEl(productId) {
        return document.querySelector(`.product-carousel[data-product-id="${productId}"]`);
    }

    function carouselGoTo(productId, index) {
        const el = getCarouselEl(productId);
        if (!el) return;

        const slides = el.querySelectorAll('img[data-slide-index]');
        const dots = el.querySelectorAll('.carousel-dot');
        const total = slides.length;
        if (total === 0) return;

        if (index < 0) index = total - 1;
        if (index >= total) index = 0;
        carouselState[productId] = index;

        slides.forEach((slide, i) => {
            if (i === index) {
                slide.classList.remove('opacity-0', 'z-0');
                slide.classList.add('opacity-100', 'z-10');
            } else {
                slide.classList.remove('opacity-100', 'z-10');
                slide.classList.add('opacity-0', 'z-0');
            }
        });

        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.remove('bg-white/50');
                dot.classList.add('bg-white', 'w-3');
            } else {
                dot.classList.remove('bg-white', 'w-3');
                dot.classList.add('bg-white/50');
                dot.style.width = '';
            }
        });
    }

    function carouselNav(productId, direction) {
        const current = carouselState[productId] || 0;
        carouselGoTo(productId, current + direction);
    }

    // Initialize related carousels
    document.querySelectorAll('.product-carousel').forEach(el => {
        carouselState[el.dataset.productId] = 0;
    });

    // Touch/swipe support
    document.querySelectorAll('.product-carousel').forEach(el => {
        let startX = 0;
        const productId = el.dataset.productId;

        el.addEventListener('touchstart', (e) => { startX = e.changedTouches[0].screenX; }, { passive: true });
        el.addEventListener('touchend', (e) => {
            const diff = startX - e.changedTouches[0].screenX;
            if (Math.abs(diff) > 50) carouselNav(productId, diff > 0 ? 1 : -1);
        }, { passive: true });
    });

    // Gallery swipe support
    const gallery = document.querySelector('#product-gallery .group');
    if (gallery) {
        let startX = 0;
        gallery.addEventListener('touchstart', (e) => { startX = e.changedTouches[0].screenX; }, { passive: true });
        gallery.addEventListener('touchend', (e) => {
            const diff = startX - e.changedTouches[0].screenX;
            if (Math.abs(diff) > 50) galleryNav(diff > 0 ? 1 : -1);
        }, { passive: true });
    }
    // ── Description Toggle ─────────────────────────────
    function initDescriptionToggle() {
        const container = document.getElementById('description-container');
        const btn = document.getElementById('toggle-description-btn');
        const overlay = document.getElementById('description-overlay');
        
        if (!container || !btn) return;

        // Check if content overflows
        if (container.scrollHeight > container.clientHeight) {
            btn.classList.remove('hidden');
        } else {
            overlay.classList.add('hidden');
            container.classList.remove('max-h-[120px]'); 
        }
    }

    function toggleDescription() {
        const container = document.getElementById('description-container');
        const overlay = document.getElementById('description-overlay');
        const btn = document.getElementById('toggle-description-btn');
        const span = btn.querySelector('span');
        const icon = btn.querySelector('i');

        if (container.classList.contains('max-h-[120px]')) {
            // Expand
            container.classList.remove('max-h-[120px]');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            span.textContent = 'View Less';
            icon.style.transform = 'rotate(180deg)';
        } else {
            // Collapse
            container.classList.add('max-h-[120px]');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            span.textContent = 'View More';
            icon.style.transform = 'rotate(0deg)';
        }
    }

    // Initialize on load to ensure accurate height calculation
    window.addEventListener('load', initDescriptionToggle);
</script>

<script>
    // ── Variant Selection ──────────────────────────────
    const basePrice = {{ $product->price }};
    const formattedBasePrice = "{{ $product->formatted_price }}";

    function selectVariant(btn) {
        // Toggle active state for this type
        const type = btn.dataset.type;
        const siblings = btn.parentElement.querySelectorAll('.variant-btn');
        const isActive = btn.classList.contains('border-amber-500');

        // Reset siblings
        siblings.forEach(sib => {
            sib.classList.remove('border-amber-500', 'bg-amber-50');
            sib.classList.add('border-gray-200', 'bg-white');
            
            // Hide checkmark
            const check = sib.querySelector('.active-check');
            if(check) check.classList.add('hidden');
        });

        if (!isActive) {
            // Activate clicked
            btn.classList.remove('border-gray-200', 'bg-white');
            btn.classList.add('border-amber-500', 'bg-amber-50');
            
            // Show checkmark
            const check = btn.querySelector('.active-check');
            if(check) check.classList.remove('hidden');

            // Update Main Image if variant has one
            const imageUrl = btn.dataset.image;
            if (imageUrl) {
                // We'll update the first image in the gallery
                const mainImg = document.querySelector('img[data-gallery-index="0"]');
                if (mainImg) {
                    // Preload first to avoid flicker
                    const temp = new Image();
                    temp.src = imageUrl;
                    temp.onload = () => {
                        mainImg.src = imageUrl;
                        galleryGoTo(0); // Ensure first image is shown
                    }
                }
            }
        } 
        
        // Recalculate Total Price
        let totalAdjustment = 0;
        // Check all active buttons across different variant types
        document.querySelectorAll('.variant-btn.border-amber-500').forEach(activeBtn => {
            totalAdjustment += parseFloat(activeBtn.dataset.priceDiff || 0);
        });

        const newPrice = basePrice + totalAdjustment;
        
        // Format price (Rp)
        const priceElement = document.querySelector('.text-3xl.font-extrabold');
        if (priceElement) {
            priceElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(newPrice);
        }
    }
</script>

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

@endsection
