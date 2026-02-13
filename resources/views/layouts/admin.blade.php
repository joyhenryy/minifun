<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — MINIFUN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">
    <div class="flex min-h-screen">

        {{-- ═══════ SIDEBAR ═══════ --}}
        <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-black text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="flex flex-col h-full">
                {{-- Brand --}}
                <div class="flex items-center gap-3 px-6 py-6 border-b border-gray-800">
                    <div class="w-9 h-9 bg-amber-500 rounded-lg flex items-center justify-center">
                        <span class="text-black font-black text-sm">M</span>
                    </div>
                    <div>
                        <span class="font-bold text-sm tracking-tight">MINI<span class="text-amber-500">FUN</span></span>
                        <p class="text-xs text-gray-500">Admin Panel</p>
                    </div>
                </div>

                {{-- Nav Links --}}
                <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500/10 text-amber-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fas fa-chart-pie w-5 text-center"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-amber-500/10 text-amber-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fas fa-car w-5 text-center"></i>
                        <span>Products</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-amber-500/10 text-amber-500' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        <i class="fas fa-tags w-5 text-center"></i>
                        <span>Categories</span>
                    </a>

                    <div class="pt-6 mt-6 border-t border-gray-800">
                        <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-800 transition-all duration-200">
                            <i class="fas fa-external-link-alt w-5 text-center"></i>
                            <span>View Website</span>
                        </a>
                    </div>
                </nav>

                {{-- User/Logout --}}
                <div class="px-4 py-4 border-t border-gray-800">
                    <div class="flex items-center gap-3 px-4 py-3">
                        <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center">
                            <i class="fas fa-user text-xs text-gray-400"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-red-400 hover:bg-red-500/10 transition-all duration-200">
                            <i class="fas fa-sign-out-alt w-5 text-center"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- ═══════ MAIN ═══════ --}}
        <div class="flex-1 lg:ml-64">
            {{-- Top Bar --}}
            <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-gray-100">
                <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
                    <div class="flex items-center gap-4">
                        <button id="sidebar-toggle" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-colors">
                            <i class="fas fa-bars text-gray-600"></i>
                        </button>
                        <h1 class="text-lg font-semibold text-gray-900">@yield('page_title', 'Dashboard')</h1>
                    </div>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mx-4 sm:mx-6 lg:mx-8 mt-4">
                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm animate-fade-in">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            {{-- Content --}}
            <div class="p-4 sm:p-6 lg:p-8">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Sidebar overlay (mobile) --}}
    <div id="sidebar-overlay" class="fixed inset-0 z-30 bg-black/50 hidden lg:hidden" onclick="closeSidebar()"></div>

    <script>
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        document.getElementById('sidebar-toggle')?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        });

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    </script>
</body>
</html>
