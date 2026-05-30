@extends('layouts.admin')
@section('title', 'Workouts')
@section('content')
<div class="space-y-6">
    <div>
        <p class="text-sm font-bold uppercase tracking-widest text-emerald-500">Records</p>
        <h1 class="text-3xl font-extrabold text-slate-900">Workouts</h1>
        <p class="mt-1 text-slate-500">View workout logs submitted by users.</p>
    </div>

    <div class="admin-card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="admin-table w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th>User</th>
                        <th>Workout</th>
                        <th>Type</th>
                        <th>Minutes</th>
                        <th>Calories</th>
                        <th>Steps</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($workouts as $workout)
                    <tr>
                        <td class="font-bold text-slate-800">{{ $workout->user?->name ?? 'Deleted user' }}</td>
                        <td>{{ $workout->name }}</td>
                        <td>{{ $workout->type ?? '-' }}</td>
                        <td>{{ $workout->duration_minutes ?? 0 }}</td>
                        <td>{{ $workout->calories_burned ?? 0 }}</td>
                        <td>{{ $workout->steps ?? 0 }}</td>
                        <td class="text-slate-500">{{ $workout->workout_date?->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-slate-500">No workouts found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $workouts->links() }}
</div>
@endsection
