@extends('layouts.admin')
@section('title', 'Create Category')
@section('page-title', 'Create Category')

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">Category Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:border-orange-500 outline-none" required>
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2.5 rounded-lg font-semibold">Save</button>
                <a href="{{ route('admin.categories.index') }}" class="bg-slate-200 hover:bg-slate-300 px-6 py-2.5 rounded-lg font-semibold">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection