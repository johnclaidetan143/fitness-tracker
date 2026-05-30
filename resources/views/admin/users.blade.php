@extends('layouts.admin')
@section('title', 'Users')
@section('content')
<div class="space-y-6">
    <div>
        <p class="text-sm font-bold uppercase tracking-widest text-indigo-500">Records</p>
        <h1 class="text-3xl font-extrabold text-slate-900">Users</h1>
        <p class="mt-1 text-slate-500">View registered users and their account roles.</p>
    </div>

    <div class="admin-card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="admin-table w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Age</th>
                        <th>Weight</th>
                        <th>Height</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr>
                        <td class="font-bold text-slate-800">{{ $user->name }}</td>
                        <td class="text-slate-500">{{ $user->email }}</td>
                        <td>
                            <span class="rounded-full px-3 py-1 text-xs font-bold {{ $user->is_admin ? 'bg-amber-100 text-amber-700' : 'bg-indigo-100 text-indigo-700' }}">
                                {{ $user->is_admin ? 'Admin' : 'User' }}
                            </span>
                        </td>
                        <td>{{ $user->age ?? '-' }}</td>
                        <td>{{ $user->weight ? $user->weight.' kg' : '-' }}</td>
                        <td>{{ $user->height ? $user->height.' cm' : '-' }}</td>
                        <td class="text-slate-500">{{ $user->created_at?->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-slate-500">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $users->links() }}
</div>
@endsection
