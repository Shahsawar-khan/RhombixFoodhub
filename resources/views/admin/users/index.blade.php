@extends('layouts.admin')
@section('title', 'Users')
@section('page-title', 'Users Management')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200">
        <h2 class="font-bold">All Users</h2>
    </div>
    <table class="w-full">
        <thead class="bg-slate-50">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Name</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Email</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Role</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Joined</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="border-t border-slate-100 hover:bg-slate-50">
                    <td class="px-6 py-3 text-sm font-medium">{{ $user->name }}</td>
                    <td class="px-6 py-3 text-sm text-slate-600">{{ $user->email }}</td>
                    <td class="px-6 py-3">
                        @if($user->hasRole('admin'))
                            <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded text-xs font-bold uppercase">Admin</span>
                        @else
                            <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-bold uppercase">User</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-sm text-slate-500">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-3 text-sm">
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline font-medium">Delete</button>
                            </form>
                        @else
                            <span class="text-slate-400 text-xs">You</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4">{{ $users->links() }}</div>
</div>
@endsection