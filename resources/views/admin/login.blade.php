<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — MINIFUN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-white font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden">
    {{-- Background Effects --}}
    <div class="absolute inset-0">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-amber-500/10 rounded-full blur-[150px]"></div>
        <div class="absolute bottom-0 right-1/4 w-72 h-72 bg-red-500/10 rounded-full blur-[120px]"></div>
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.03) 1px, transparent 0); background-size: 40px 40px;"></div>
    </div>

    <div class="relative w-full max-w-md mx-4">
        {{-- Logo --}}
        <div class="text-center mb-10">
            <div class="w-16 h-16 mx-auto bg-amber-500 rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-amber-500/20">
                <span class="text-black font-black text-2xl">M</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight">MINI<span class="text-amber-500">FUN</span></h1>
            <p class="text-gray-500 text-sm mt-1">Administration Portal</p>
        </div>

        {{-- Login Form --}}
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8">
            <h2 class="text-lg font-bold mb-6">Sign In</h2>

            @if($errors->any())
                <div class="mb-6 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wide">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm transition-all duration-300" placeholder="admin@minifun.com">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wide">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm transition-all duration-300" placeholder="••••••••">
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-600 bg-gray-800 text-amber-500 focus:ring-amber-500/20">
                        <span class="text-xs text-gray-400">Remember me</span>
                    </label>
                </div>
                <button type="submit" class="w-full py-3.5 bg-amber-500 hover:bg-amber-400 text-black font-bold text-sm rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-amber-500/25 hover:scale-[1.02]">
                    Sign In
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-600 mt-6">
            &copy; {{ date('Y') }} MINIFUN. Admin access only.
        </p>
    </div>
</body>
</html>
