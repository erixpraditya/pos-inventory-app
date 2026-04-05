<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'POS Inventory') }}</title>
    <!-- Tailwind CSS v4 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
          --color-primary: #3b82f6;
          --font-sans: 'Inter', system-ui, sans-serif;
        }
    </style>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans text-gray-800">
    <nav class="bg-white shadow-sm mb-6">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a class="text-xl font-bold text-gray-800 flex items-center gap-2" href="{{ url('/') }}">
                    <i class="fas fa-cash-register text-blue-500"></i>
                    POS System
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-6">
                    {{-- <a class="flex items-center gap-1 hover:text-blue-600 {{ request()->routeIs('transactions.create') ? 'text-blue-600 font-semibold' : 'text-gray-600' }}" href="{{ route('transactions.create') }}">
                        <i class="fas fa-calculator"></i> POS
                    </a> --}}
                    {{-- <a class="flex items-center gap-1 hover:text-blue-600 {{ request()->routeIs('transactions.index') ? 'text-blue-600 font-semibold' : 'text-gray-600' }}" href="{{ route('transactions.index') }}">
                        <i class="fas fa-history"></i> History
                    </a> --}}
                    <a class="flex items-center gap-1 hover:text-blue-600 {{ request()->routeIs('products.*') ? 'text-blue-600 font-semibold' : 'text-gray-600' }}" href="{{ route('products.index') }}">
                        <i class="fas fa-box"></i> Products
                    </a>
                    <a class="flex items-center gap-1 hover:text-blue-600 {{ request()->routeIs('categories.*') ? 'text-blue-600 font-semibold' : 'text-gray-600' }}" href="{{ route('categories.index') }}">
                        <i class="fas fa-tags"></i> Categories
                    </a>
                    {{-- <a class="flex items-center gap-1 hover:text-blue-600 {{ request()->routeIs('reports.*') ? 'text-blue-600 font-semibold' : 'text-gray-600' }}" href="{{ route('reports.index') }}">
                        <i class="fas fa-chart-line"></i> Reports
                    </a> --}}
                </div>

                <!-- Mobile Menu Button (Simple implementation) -->
                <button class="md:hidden text-gray-500 focus:outline-none" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <i class="fas fa-bars fa-lg"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 p-4">
            <div class="flex flex-col space-y-3">
                {{-- <a class="block text-gray-600 hover:text-blue-600" href="{{ route('transactions.create') }}">POS</a> --}}
                {{-- <a class="block text-gray-600 hover:text-blue-600" href="{{ route('transactions.index') }}">History</a> --}}
                <a class="block text-gray-600 hover:text-blue-600" href="{{ route('products.index') }}">Products</a>
                <a class="block text-gray-600 hover:text-blue-600" href="{{ route('categories.index') }}">Categories</a>
                {{-- <a class="block text-gray-600 hover:text-blue-600" href="{{ route('reports.index') }}">Reports</a> --}}
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    <i class="fas fa-times cursor-pointer"></i>
                </span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                 <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    <i class="fas fa-times cursor-pointer"></i>
                </span>
            </div>
        @endif

        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
