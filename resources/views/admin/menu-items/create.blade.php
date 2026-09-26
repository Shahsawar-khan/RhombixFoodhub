@extends('layouts.admin')
@section('title', 'Create Menu Item')
@section('page-title', 'Create Menu Item')

@section('content')
<form action="{{ route('admin.menu-items.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <label class="block text-sm font-semibold mb-2">Item Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:border-orange-500 outline-none text-lg" required>
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <label class="block text-sm font-semibold mb-2">Description</label>
                <textarea name="description" rows="5"
                          class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:border-orange-500 outline-none">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-bold mb-4">Publish</h3>
                <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg font-semibold">Save Item</button>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-bold mb-4">Details</h3>

                <label class="block text-sm font-semibold mb-2">Category</label>
                <select name="category_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg mb-3" required>
                    <option value="">Select category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>

                <label class="block text-sm font-semibold mb-2">Price (₨)</label>
                <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg mb-3" required>

                <label class="flex items-center gap-2 text-sm mb-2">
                    <input type="checkbox" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                    Available
                </label>

                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                    Featured
                </label>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-bold mb-4">Image</h3>
                <input type="file" name="image" accept="image/*"
                       class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-50 file:text-orange-700 file:font-semibold">
            </div>
        </div>
    </div>
</form>
@endsection