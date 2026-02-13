@extends('layouts.app')

@section('title', 'Home')
@section('meta_description', 'MINIFUN — Your premium destination for high-quality diecast collectibles. Hot Wheels, Tomica, Matchbox & more.')

@section('content')

{{-- ═══════ HERO SECTION ═══════ --}}
<section class="relative overflow-hidden bg-black text-white min-h-[90vh] flex items-center">
    {{-- Animated Background Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-20 left-10 w-72 h-72 bg-amber-500 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-red-500 rounded-full blur-[150px] animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-yellow-500 rounded-full blur-[100px] animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    {{-- Grid Pattern Overlay --}}
    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.05) 1px, transparent 0); background-size: 40px 40px;"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="max-w-3xl animate-fade-in">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm mb-8">
                <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                <span class="text-xs font-medium text-gray-300 tracking-wide uppercase">Premium Diecast Collection</span>
            </div>

            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black leading-tight tracking-tight">
                Collect the
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-yellow-500 to-amber-600">Extraordinary</span>
            </h1>

            <p class="mt-6 text-lg sm:text-xl text-gray-400 leading-relaxed max-w-2xl">
                Discover our curated selection of premium diecast models — from legendary supercars to limited editions. Every detail matters.
            </p>

            <div class="mt-10 flex flex-wrap items-center gap-4">
                <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-amber-500 hover:bg-amber-400 text-black font-bold text-sm rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-amber-500/25">
                    <span>Explore Collection</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="{{ route('catalog.index', ['category' => 'limited-edition']) }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-medium text-sm rounded-xl transition-all duration-300 backdrop-blur-sm">
                    <i class="fas fa-crown text-amber-500"></i>
                    <span>Limited Editions</span>
                </a>
            </div>

            {{-- Stats --}}
            <div class="mt-16 flex items-center gap-8 sm:gap-12">
                <div>
                    <div class="text-3xl font-black text-white">500<span class="text-amber-500">+</span></div>
                    <div class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wide">Products</div>
                </div>
                <div class="w-px h-12 bg-gray-800"></div>
                <div>
                    <div class="text-3xl font-black text-white">50<span class="text-amber-500">+</span></div>
                    <div class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wide">Brands</div>
                </div>
                <div class="w-px h-12 bg-gray-800"></div>
                <div>
                    <div class="text-3xl font-black text-white">10K<span class="text-amber-500">+</span></div>
                    <div class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wide">Happy Collectors</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════ FEATURED PRODUCTS ═══════ --}}
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 mb-12">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-amber-500">Handpicked for You</span>
                <h2 class="mt-2 text-3xl sm:text-4xl font-black text-black tracking-tight">Featured Collection</h2>
            </div>
            <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-black transition-colors group">
                View All
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        {{-- Product Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredProducts as $product)
                @php $imageUrls = $product->all_image_urls; @endphp
                <div class="group block bg-white rounded-2xl border border-gray-100 hover:border-gray-200 overflow-hidden transition-all duration-500 hover:shadow-2xl hover:shadow-black/5 hover:-translate-y-1">
                    {{-- Image Carousel --}}
                    <div class="relative aspect-square bg-gray-50 overflow-hidden product-carousel" data-product-id="feat-{{ $product->id }}">
                        @foreach($imageUrls as $index => $url)
                            <img
                                src="{{ $url }}"
                                alt="{{ $product->name }} - Image {{ $index + 1 }}"
                                class="absolute inset-0 w-full h-full object-cover transition-all duration-500 ease-in-out {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }}"
                                data-slide-index="{{ $index }}"
                                loading="lazy"
                            >
                        @endforeach

                        @if(count($imageUrls) > 1)
                            <button class="absolute left-2 top-1/2 -translate-y-1/2 z-20 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:bg-white hover:text-black shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110" onclick="event.preventDefault(); event.stopPropagation(); carouselNav('feat-{{ $product->id }}', -1)">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </button>
                            <button class="absolute right-2 top-1/2 -translate-y-1/2 z-20 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-gray-600 hover:bg-white hover:text-black shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 hover:scale-110" onclick="event.preventDefault(); event.stopPropagation(); carouselNav('feat-{{ $product->id }}', 1)">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </button>

                            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1.5 px-2.5 py-1.5 rounded-full bg-black/30 backdrop-blur-sm">
                                @foreach($imageUrls as $dotIndex => $url)
                                    <button class="carousel-dot w-1.5 h-1.5 rounded-full transition-all duration-300 {{ $dotIndex === 0 ? 'bg-white w-4' : 'bg-white/50 hover:bg-white/75' }}" data-dot-index="{{ $dotIndex }}" onclick="event.preventDefault(); event.stopPropagation(); carouselGoTo('feat-{{ $product->id }}', {{ $dotIndex }})"></button>
                                @endforeach
                            </div>

                            <div class="absolute top-3 right-3 z-20 px-2 py-1 rounded-lg bg-black/40 backdrop-blur-sm text-white text-[10px] font-semibold opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="fas fa-images mr-1"></i>
                                <span class="carousel-counter">1</span>/{{ count($imageUrls) }}
                            </div>
                        @endif

                        @if($product->is_featured)
                            <div class="absolute top-3 left-3 z-20 px-2.5 py-1 bg-amber-500 text-black text-xs font-bold rounded-lg">
                                <i class="fas fa-star mr-1"></i> Featured
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <a href="{{ route('catalog.show', $product->slug) }}" class="block p-5">
                        <div class="text-xs font-medium text-amber-600 mb-1">{{ $product->category->name ?? 'Uncategorized' }}</div>
                        <h3 class="font-bold text-gray-900 group-hover:text-amber-600 transition-colors line-clamp-2">{{ $product->name }}</h3>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-lg font-black text-black">{{ $product->formatted_price }}</span>
                            <span class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 group-hover:bg-amber-500 group-hover:text-black text-gray-400 transition-all duration-300 text-xs">
                                <i class="fas fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-box-open text-2xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">No Featured Products Yet</h3>
                    <p class="text-gray-500 text-sm mt-1">Check back soon for our curated picks.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ═══════ CATEGORIES SHOWCASE ═══════ --}}
<section class="py-20 lg:py-28 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-xs font-semibold uppercase tracking-wider text-amber-500">Browse By</span>
            <h2 class="mt-2 text-3xl sm:text-4xl font-black text-black tracking-tight">Shop Categories</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @php
                $icons = ['fas fa-car-side', 'fas fa-truck', 'fas fa-motorcycle', 'fas fa-cog', 'fas fa-crown'];
                $colors = ['from-red-500 to-orange-500', 'from-blue-500 to-cyan-500', 'from-green-500 to-emerald-500', 'from-purple-500 to-pink-500', 'from-amber-500 to-yellow-500'];
            @endphp
            @foreach($categories as $index => $category)
                <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="group relative flex flex-col items-center justify-center p-6 lg:p-8 rounded-2xl bg-white border border-gray-100 hover:border-transparent overflow-hidden transition-all duration-500 hover:shadow-xl hover:-translate-y-1">
                    <div class="absolute inset-0 bg-gradient-to-br {{ $colors[$index % count($colors)] }} opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-14 h-14 rounded-2xl bg-gray-100 group-hover:bg-white/20 flex items-center justify-center mb-4 transition-all duration-300">
                            <i class="{{ $icons[$index % count($icons)] }} text-xl text-gray-400 group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <h3 class="font-bold text-sm text-gray-900 group-hover:text-white transition-colors text-center">{{ $category->name }}</h3>
                        <span class="mt-1 text-xs text-gray-400 group-hover:text-white/70 transition-colors">{{ $category->products_count }} items</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════ WHY MINIFUN ═══════ --}}
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-xs font-semibold uppercase tracking-wider text-amber-500">Why Choose Us</span>
            <h2 class="mt-2 text-3xl sm:text-4xl font-black text-black tracking-tight">The MINIFUN Difference</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $features = [
                    ['icon' => 'fas fa-gem', 'title' => '100% Authentic', 'desc' => 'Every product is sourced from authorized distributors. No counterfeits, ever.'],
                    ['icon' => 'fas fa-shipping-fast', 'title' => 'Safe Packaging', 'desc' => 'Double-layered protection ensures your collectible arrives in mint condition.'],
                    ['icon' => 'fas fa-tags', 'title' => 'Best Prices', 'desc' => 'Competitive pricing across all brands. We offer the best value for collectors.'],
                    ['icon' => 'fas fa-headset', 'title' => 'Expert Support', 'desc' => 'Our team of collectors is here to help you find exactly what you need.'],
                ];
            @endphp

            @foreach($features as $feature)
                <div class="group text-center p-6 rounded-2xl hover:bg-gray-50 transition-all duration-300">
                    <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-amber-50 group-hover:bg-amber-500 flex items-center justify-center transition-all duration-300 group-hover:scale-110">
                        <i class="{{ $feature['icon'] }} text-xl text-amber-500 group-hover:text-white transition-colors"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════ CTA BANNER ═══════ --}}
<section class="py-20 lg:py-28 bg-black text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 right-0 w-96 h-96 bg-amber-500 rounded-full blur-[150px]"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-red-600 rounded-full blur-[120px]"></div>
    </div>

    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight">
            Start Your Collection <span class="text-amber-500">Today</span>
        </h2>
        <p class="mt-4 text-gray-400 text-lg max-w-2xl mx-auto">
            Browse our full catalog and find your next prized collectible. Available on Shopee or contact us directly via WhatsApp.
        </p>
        <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-amber-500 hover:bg-amber-400 text-black font-bold text-sm rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-amber-500/25">
                <i class="fas fa-store"></i>
                <span>Browse Catalog</span>
            </a>
            <a href="https://wa.me/{{ env('WHATSAPP_NUMBER', '6281234567890') }}" target="_blank" class="inline-flex items-center gap-2 px-8 py-4 bg-green-600 hover:bg-green-500 text-white font-bold text-sm rounded-xl transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-green-500/25">
                <i class="fab fa-whatsapp text-lg"></i>
                <span>Chat on WhatsApp</span>
            </a>
        </div>
    </div>
</section>


{{-- Carousel JavaScript --}}
<script>
    const carouselState = {};

    function getCarouselEl(productId) {
        return document.querySelector(`.product-carousel[data-product-id="${productId}"]`);
    }

    function carouselGoTo(productId, index) {
        const el = getCarouselEl(productId);
        if (!el) return;

        const slides = el.querySelectorAll('img[data-slide-index]');
        const dots = el.querySelectorAll('.carousel-dot');
        const counter = el.querySelector('.carousel-counter');
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
                dot.classList.remove('bg-white/50', 'hover:bg-white/75');
                dot.classList.add('bg-white', 'w-4');
            } else {
                dot.classList.remove('bg-white', 'w-4');
                dot.classList.add('bg-white/50', 'hover:bg-white/75');
                dot.style.width = '';
            }
        });

        if (counter) counter.textContent = index + 1;
    }

    function carouselNav(productId, direction) {
        const current = carouselState[productId] || 0;
        carouselGoTo(productId, current + direction);
    }

    document.querySelectorAll('.product-carousel').forEach(el => {
        const productId = el.dataset.productId;
        carouselState[productId] = 0;

        let startX = 0;
        el.addEventListener('touchstart', (e) => { startX = e.changedTouches[0].screenX; }, { passive: true });
        el.addEventListener('touchend', (e) => {
            const diff = startX - e.changedTouches[0].screenX;
            if (Math.abs(diff) > 50) carouselNav(productId, diff > 0 ? 1 : -1);
        }, { passive: true });
    });
</script>

@endsection
