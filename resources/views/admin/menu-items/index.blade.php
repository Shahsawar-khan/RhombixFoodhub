@extends('layouts.admin')
@section('title', 'Menu Items')
@section('page-title', 'Menu Items Management')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
        <h2 class="font-bold">All Menu Items</h2>
        <a href="{{ route('admin.menu-items.create') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">+ New Item</a>
    </div>
    <table class="w-full">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Image</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Name</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Category</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Price</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Status</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menuItems as $item)
                <tr class="border-t border-slate-100 hover:bg-slate-50">
                    <td class="px-6 py-3">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-14 h-14 object-cover rounded-lg">
                        @else
                            <div class="w-14 h-14 bg-orange-100 rounded-lg flex items-center justify-center text-xl">🍽️</div>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-sm font-medium">{{ $item->name }}</td>
                    <td class="px-6 py-3 text-sm">{{ $item->category->name ?? '—' }}</td>
                    <td class="px-6 py-3 text-sm font-bold text-orange-600">₨{{ number_format($item->price, 0) }}</td>
                    <td class="px-6 py-3">
                        @if($item->is_available)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold uppercase">Available</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold uppercase">Unavailable</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-sm flex gap-2">
                        <a href="{{ route('admin.menu-items.edit', $item) }}" class="text-orange-600 hover:underline font-medium">Edit</a>
                        <form action="{{ route('admin.menu-items.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-slate-400">No menu items yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $menuItems->links() }}</div>
</div>
@endsection