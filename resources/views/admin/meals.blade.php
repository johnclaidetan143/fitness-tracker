@extends('layouts.admin')
@section('title', 'Meals')
@section('content')
<div class="space-y-6">
    <div>
        <p class="text-sm font-bold uppercase tracking-widest text-orange-500">Records</p>
        <h1 class="text-3xl font-extrabold text-slate-900">Meals</h1>
        <p class="mt-1 text-slate-500">View user meal logs and nutrition details.</p>
    </div>

    <div class="admin-card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="admin-table w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th>User</th>
                        <th>Meal</th>
                        <th>Type</th>
                        <th>Calories</th>
                        <th>Protein</th>
                        <th>Carbs</th>
                        <th>Fat</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($meals as $meal)
                    <tr>
                        <td class="font-bold text-slate-800">{{ $meal->user?->name ?? 'Deleted user' }}</td>
                        <td>{{ $meal->name }}</td>
                        <td>{{ ucfirst($meal->meal_type ?? '-') }}</td>
                        <td>{{ $meal->calories ?? 0 }}</td>
                        <td>{{ $meal->protein ?? 0 }}g</td>
                        <td>{{ $meal->carbs ?? 0 }}g</td>
                        <td>{{ $meal->fat ?? 0 }}g</td>
                        <td class="text-slate-500">{{ $meal->meal_date?->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-slate-500">No meals found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $meals->links() }}
</div>
@endsection
