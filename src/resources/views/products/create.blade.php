@extends('layouts.app')

@section('content')
<div class="flex justify-center">
    <div class="w-full max-w-4xl">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h5 class="font-bold text-gray-800">Create Product</h5>
            </div>
            <div class="p-6">
                <!-- Scanner Section -->
                 <div class="mb-5 hidden" id="scanner-container">
                    <div id="reader" width="100%"></div>
                    <button type="button" class="mt-2 text-sm text-red-600 hover:text-red-800" onclick="stopScanner()">Stop Scanner</button>
                </div>

                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                        <div class="relative">
                            <label for="code" class="block mb-2 text-sm font-medium text-gray-700">Product Code (Barcode)</label>
                            <div class="flex gap-2">
                                <input type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('code') border-red-500 @else border-gray-300 @enderror" id="code" name="code" value="{{ old('code') }}" required>
                                <button type="button" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-600 transition" onclick="startScanner()">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                            @error('code')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Product Name</label>
                            <input type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('name') border-red-500 @else border-gray-300 @enderror" id="name" name="name" value="{{ old('name') }}" required>
                             @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-5">
                        <div class="md:col-span-2">
                            <label for="category_slug" class="block mb-2 text-sm font-medium text-gray-700">Category</label>
                            <select class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('category_slug') border-red-500 @else border-gray-300 @enderror" id="category_slug" name="category_slug" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ old('category_slug') == $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                             @error('category_slug')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="price" class="block mb-2 text-sm font-medium text-gray-700">Price</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-100 border border-r-0 border-gray-300 rounded-l-md">
                                    Rp
                                </span>
                                <input type="number" class="w-full px-4 py-2 border rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('price') border-red-500 @else border-gray-300 @enderror" id="price" name="price" value="{{ old('price') }}" required min="0">
                            </div>
                             @error('price')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="stock" class="block mb-2 text-sm font-medium text-gray-700">Stock</label>
                            <input type="number" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('stock') border-red-500 @else border-gray-300 @enderror" id="stock" name="stock" value="{{ old('stock') }}" required min="0">
                             @error('stock')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-700">Product Image</label>
                        <input type="file" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100 opacity-90
                        " id="image" name="image" accept="image/*">
                         @error('image')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('products.index') }}" class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">Cancel</a>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">Save Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    let html5QrcodeScanner = null;

    function startScanner() {
        const container = document.getElementById('scanner-container');
        container.classList.remove('hidden');

        if (!html5QrcodeScanner) {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", { fps: 10, qrbox: 250 }
            );

            html5QrcodeScanner.render((decodedText, decodedResult) => {
                console.log(`Code matched = ${decodedText}`, decodedResult);
                document.getElementById('code').value = decodedText;
                stopScanner();
            }, (errorMessage) => {
                // ignore
            });
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
