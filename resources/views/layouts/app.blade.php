<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'MINIFUN — Premium Diecast Collection. Discover high-quality diecast cars, trucks, and motorcycles.')">
    <title>@yield('title', 'MINIFUN') — Premium Diecast Collection</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-black font-sans antialiased">

    {{-- ═══════ NAVBAR ═══════ --}}
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 bg-white/80 backdrop-blur-xl border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 lg:h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-black rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <span class="text-white font-black text-lg">M</span>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-black">MINI<span class="text-amber-500">FUN</span></span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'text-amber-500 font-semibold' : 'text-gray-600 hover:text-black' }} transition-colors duration-300 text-sm font-medium">Home</a>
                    <a href="{{ route('catalog.index') }}" class="nav-link {{ request()->routeIs('catalog.*') ? 'text-amber-500 font-semibold' : 'text-gray-600 hover:text-black' }} transition-colors duration-300 text-sm font-medium">Catalog</a>
                </div>

                {{-- Mobile Burger --}}
                <button id="mobile-menu-btn" class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="burger-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white/95 backdrop-blur-xl">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('home') ? 'bg-black text-white' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">Home</a>
                <a href="{{ route('catalog.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('catalog.*') ? 'bg-black text-white' : 'text-gray-700 hover:bg-gray-50' }} transition-colors">Catalog</a>
            </div>
        </div>
    </nav>

    {{-- ═══════ MAIN CONTENT ═══════ --}}
    <main class="pt-16 lg:pt-20">
        @yield('content')
    </main>

    {{-- ═══════ FOOTER ═══════ --}}
    <footer class="bg-black text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                {{-- Brand --}}
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center">
                            <span class="text-black font-black text-lg">M</span>
                        </div>
                        <span class="text-xl font-bold tracking-tight">MINI<span class="text-amber-500">FUN</span></span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">Your premium destination for high-quality diecast collectibles. From Hot Wheels to Tomica, we curate the finest miniature vehicles.</p>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-amber-500 mb-4">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white text-sm transition-colors duration-300">Home</a></li>
                        <li><a href="{{ route('catalog.index') }}" class="text-gray-400 hover:text-white text-sm transition-colors duration-300">All Products</a></li>
                    </ul>
                </div>

                {{-- Contact --}}
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-amber-500 mb-4">Get in Touch</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-gray-400 text-sm">
                            <i class="fab fa-whatsapp text-green-500"></i>
                            <span>WhatsApp Us</span>
                        </li>
                        <li class="flex items-center gap-3 text-gray-400 text-sm">
                            <i class="fab fa-shopee text-orange-500"></i>
                            <span>Shopee Store</span>
                        </li>
                        <li class="flex items-center gap-3 text-gray-400 text-sm">
                            <i class="fab fa-instagram text-pink-500"></i>
                            <span>@minifun.diecast</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-gray-500 text-xs">&copy; {{ date('Y') }} MINIFUN. All rights reserved.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-amber-500 flex items-center justify-center text-gray-400 hover:text-black transition-all duration-300">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-green-500 flex items-center justify-center text-gray-400 hover:text-white transition-all duration-300">
                        <i class="fab fa-whatsapp text-sm"></i>
                    </a>
                    <a href="#" class="w-9 h-9 rounded-full bg-gray-800 hover:bg-orange-500 flex items-center justify-center text-gray-400 hover:text-white transition-all duration-300">
                        <i class="fas fa-store text-sm"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        // Navbar scroll effect
        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            const currentScroll = window.pageYOffset;
            if (currentScroll > 60) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
            lastScroll = currentScroll;
        });
    </script>
</body>
</html>
