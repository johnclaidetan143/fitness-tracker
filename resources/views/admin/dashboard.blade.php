@extends('layouts.admin')
@section('title', 'Admin')
@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-bold uppercase tracking-widest text-indigo-500">Admin Panel</p>
            <h1 class="text-3xl font-extrabold text-slate-900">System Overview</h1>
            <p class="mt-1 text-slate-500">Monitor users and activity across FitTracker.</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="rounded-xl bg-red-500 px-4 py-2 font-bold text-white transition hover:bg-red-600">
                <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <a href="{{ route('admin.users') }}" class="admin-card block transition hover:-translate-y-1 hover:border-indigo-200 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500">Users</p>
                    <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $stats['users'] }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-100 text-indigo-600">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.workouts') }}" class="admin-card block transition hover:-translate-y-1 hover:border-emerald-200 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500">Workouts</p>
                    <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $stats['workouts'] }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600">
                    <i class="fa-solid fa-dumbbell"></i>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.meals') }}" class="admin-card block transition hover:-translate-y-1 hover:border-orange-200 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500">Meals</p>
                    <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $stats['meals'] }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-orange-100 text-orange-600">
                    <i class="fa-solid fa-utensils"></i>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.water-logs') }}" class="admin-card block transition hover:-translate-y-1 hover:border-cyan-200 hover:shadow-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-500">Water Logs</p>
                    <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $stats['waterLogs'] }}</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-cyan-100 text-cyan-600">
                    <i class="fa-solid fa-droplet"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="admin-card">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-extrabold text-slate-900">Recent Users</h2>
            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500">Latest 6</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-xs uppercase tracking-wider text-slate-400">
                        <th class="py-3 pr-4">Name</th>
                        <th class="py-3 pr-4">Email</th>
                        <th class="py-3 pr-4">Role</th>
                        <th class="py-3 pr-4">Joined</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($recentUsers as $user)
                    <tr>
                        <td class="py-4 pr-4 font-semibold text-slate-800">{{ $user->name }}</td>
                        <td class="py-4 pr-4 text-slate-500">{{ $user->email }}</td>
                        <td class="py-4 pr-4">
                            <span class="rounded-full px-3 py-1 text-xs font-bold {{ $user->is_admin ? 'bg-amber-100 text-amber-700' : 'bg-indigo-100 text-indigo-700' }}">
                                {{ $user->is_admin ? 'Admin' : 'User' }}
                            </span>
                        </td>
                        <td class="py-4 pr-4 text-slate-500">{{ $user->created_at?->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
