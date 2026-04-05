@extends('layouts.app')

@section('content')
<div class="flex justify-center">
    <div class="w-full max-w-2xl">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h5 class="font-bold text-gray-800">Create Category</h5>
            </div>
            <div class="p-6">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-5">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Name</label>
                        <input type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('name') border-red-500 @else border-gray-300 @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="slug" class="block mb-2 text-sm font-medium text-gray-700">Slug</label>
                        <input type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('slug') border-red-500 @else border-gray-300 @enderror" id="slug" name="slug" value="{{ old('slug') }}" required>
                        <p class="mt-1 text-xs text-gray-500">Unique identifier for the category (URL friendly).</p>
                        @error('slug')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-700">Description</label>
                        <textarea class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('description') border-red-500 @else border-gray-300 @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                           <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('categories.index') }}" class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">Cancel</a>
                        <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
