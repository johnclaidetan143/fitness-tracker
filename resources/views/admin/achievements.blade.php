@extends('layouts.admin')
@section('title', 'Achievements')
@section('content')
<div class="space-y-6">
    <div>
        <p class="text-sm font-bold uppercase tracking-widest text-violet-500">Insights</p>
        <h1 class="text-3xl font-extrabold text-slate-900">Achievements</h1>
        <p class="mt-1 text-slate-500">View achievement badges and how many users earned them.</p>
    </div>

    <div class="admin-card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="admin-table w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th>Badge</th>
                        <th>Key</th>
                        <th>Description</th>
                        <th>Earned By</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($achievements as $achievement)
                    <tr>
                        <td class="font-bold text-slate-800">
                            <i class="fa-solid {{ $achievement->icon ?? 'fa-medal' }} mr-2 text-{{ $achievement->color ?? 'violet' }}-500"></i>
                            {{ $achievement->name }}
                        </td>
                        <td class="text-slate-500">{{ $achievement->key }}</td>
                        <td>{{ $achievement->description }}</td>
                        <td>{{ $achievement->users_count }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-slate-500">No achievements found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $achievements->links() }}
</div>
@endsection
