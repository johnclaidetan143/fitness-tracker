@extends('layouts.admin')
@section('title', 'Water Logs')
@section('content')
<div class="space-y-6">
    <div>
        <p class="text-sm font-bold uppercase tracking-widest text-cyan-500">Records</p>
        <h1 class="text-3xl font-extrabold text-slate-900">Water Logs</h1>
        <p class="mt-1 text-slate-500">View hydration records submitted by users.</p>
    </div>

    <div class="admin-card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="admin-table w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th>User</th>
                        <th>Glasses</th>
                        <th>Milliliters</th>
                        <th>Date</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($waterLogs as $waterLog)
                    <tr>
                        <td class="font-bold text-slate-800">{{ $waterLog->user?->name ?? 'Deleted user' }}</td>
                        <td>{{ $waterLog->glasses ?? 0 }}</td>
                        <td>{{ $waterLog->ml ?? 0 }} ml</td>
                        <td class="text-slate-500">{{ $waterLog->log_date?->format('M d, Y') }}</td>
                        <td class="text-slate-500">{{ $waterLog->created_at?->format('M d, Y h:i A') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-slate-500">No water logs found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $waterLogs->links() }}
</div>
@endsection
