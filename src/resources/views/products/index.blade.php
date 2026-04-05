@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Product List</h2>
        <p class="text-gray-500">Manage your product inventory</p>
    </div>
    <div class="flex gap-3 w-full md:w-auto">
        <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm whitespace-nowrap">
            <i class="fas fa-plus mr-2"></i> Add Product
        </a>
    </div>
</div>

<!-- Search & Filter -->
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <div class="hidden mb-4 rounded-lg overflow-hidden border border-gray-200" id="scanner-container">
        <div id="reader" class="w-full max-w-md mx-auto"></div>
        <button type="button" class="mt-2 text-sm text-red-600 hover:text-red-800 p-2" onclick="stopScanner()">Stop Scanner</button>
    </div>

    <form action="{{ route('products.index') }}" method="GET" class="relative flex gap-2" id="search-form">
        <div class="relative w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" name="search" id="search-input" value="{{ request('search') }}" class="block w-full p-3 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Search by product name or code..." onchange="this.form.submit()">
        </div>
        <button type="button" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-600 transition" onclick="toggleScanner()" title="Scan Barcode">
            <i class="fas fa-camera"></i>
        </button>
    </form>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-700 uppercase font-semibold">
                <tr>
                    <th class="px-6 py-4">Product</th>
                    <th class="px-6 py-4">Code</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4 text-right">Price</th>
                    <th class="px-6 py-4 text-center">Stock</th>
                    <th class="px-6 py-4 text-center">Barcode</th>
                    <th class="px-6 py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="h-10 w-10 rounded-lg object-cover border border-gray-200">
                            @else
                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                <i class="fas fa-box"></i>
                            </div>
                            @endif
                            <span class="font-medium text-gray-900">{{ $product->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-mono text-xs bg-gray-50 rounded px-2 py-1 mx-auto w-fit">{{ $product->code }}</td>
                    <td class="px-6 py-4">
                        <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-2.5 py-0.5 rounded">
                            {{ $product->category->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($product->stock <= 5)
                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $product->stock }}</span>
                        @else
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $product->stock }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center">
                            @php
                                $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                            @endphp
                            <img src="data:image/png;base64,{{ base64_encode($generator->getBarcode($product->code, $generator::TYPE_CODE_128)) }}" class="h-6">
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('products.edit', $product) }}" class="p-2 text-yellow-500 hover:text-yellow-600 transition" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:text-red-600 transition" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                         <div class="flex flex-col items-center">
                            <i class="fas fa-box-open fa-3x mb-2"></i>
                            <p>No products found.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-4 border-t border-gray-100 bg-gray-50">
        {{ $products->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScanner = null;

    function toggleScanner() {
        const container = document.getElementById('scanner-container');

        if (container.classList.contains('hidden')) {
            container.classList.remove('hidden');

            if (!html5QrcodeScanner) {
                html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader", {
                        fps: 10,
                        qrbox: { width: 400, height: 150 },
                        aspectRatio: 1.777778
                    }
                );

                html5QrcodeScanner.render((decodedText, decodedResult) => {
                    console.log(`Code matched = ${decodedText}`, decodedResult);
                    document.getElementById('search-input').value = decodedText;
                    document.getElementById('search-form').submit();
                    stopScanner();
                }, (errorMessage) => {
                    // ignore
                });
            }
        } else {
            stopScanner();
        }
    }

    function stopScanner() {
        const container = document.getElementById('scanner-container');
        container.classList.add('hidden');

        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear().catch(error => {
                console.error("Failed to clear html5QrcodeScanner. ", error);
            });
            html5QrcodeScanner = null;
        }
    }
</script>
@endpush
