@extends('layouts.app')
@section('title', 'Reports')
@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">📊 Reports</h1>
    <p class="text-slate-500 text-sm mt-1">{{ now()->format('F Y') }} summary</p>
</div>

{{-- This Month Summary --}}
<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
    @php
    $summaryCards = [
        ['label' => 'Workouts',      'value' => $summary['total_workouts'],              'unit' => '',      'icon' => 'fa-dumbbell',    'color' => 'indigo'],
        ['label' => 'Total Steps',   'value' => number_format($summary['total_steps']),  'unit' => '',      'icon' => 'fa-shoe-prints', 'color' => 'green'],
        ['label' => 'Calories Out',  'value' => number_format($summary['total_calories']),'unit' => 'kcal', 'icon' => 'fa-fire',        'color' => 'orange'],
        ['label' => 'Active Time',   'value' => $summary['total_minutes'],               'unit' => 'min',   'icon' => 'fa-clock',       'color' => 'purple'],
        ['label' => 'Water',         'value' => $summary['total_water'],                 'unit' => 'gl',    'icon' => 'fa-droplet',     'color' => 'cyan'],
        ['label' => 'Calories In',   'value' => number_format($summary['total_meals_cal']),'unit' => 'kcal','icon' => 'fa-utensils',    'color' => 'pink'],
    ];
    $cMap = ['indigo'=>'text-indigo-600 bg-indigo-100','green'=>'text-green-600 bg-green-100','orange'=>'text-orange-600 bg-orange-100','purple'=>'text-purple-600 bg-purple-100','cyan'=>'text-cyan-600 bg-cyan-100','pink'=>'text-pink-600 bg-pink-100'];
    @endphp
    @foreach($summaryCards as $sc)
    <div class="card text-center p-4">
        <div class="w-10 h-10 {{ $cMap[$sc['color']] }} rounded-xl flex items-center justify-center mx-auto mb-2">
            <i class="fa-solid {{ $sc['icon'] }}"></i>
        </div>
        <p class="text-xl font-bold text-slate-800">{{ $sc['value'] }}<span class="text-xs text-slate-400 ml-1">{{ $sc['unit'] }}</span></p>
        <p class="text-xs text-slate-500">{{ $sc['label'] }}</p>
    </div>
    @endforeach
</div>

{{-- Weekly Chart --}}
<div class="card mb-5">
    <h2 class="font-bold text-slate-800 mb-4">Weekly Breakdown (Last 4 Weeks)</h2>
    <canvas id="weeklyChart" height="80"></canvas>
</div>

{{-- Monthly Chart --}}
<div class="card mb-5">
    <h2 class="font-bold text-slate-800 mb-4">Monthly Trend (Last 6 Months)</h2>
    <canvas id="monthlyChart" height="80"></canvas>
</div>

{{-- Weekly Table --}}
<div class="card">
    <h2 class="font-bold text-slate-800 mb-4">Weekly Summary Table</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="text-left py-2 text-slate-500 font-medium">Week</th>
                    <th class="text-right py-2 text-slate-500 font-medium">Workouts</th>
                    <th class="text-right py-2 text-slate-500 font-medium">Steps</th>
                    <th class="text-right py-2 text-slate-500 font-medium">Calories</th>
                    <th class="text-right py-2 text-slate-500 font-medium">Minutes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($weeks as $week)
                <tr class="border-b border-slate-50 hover:bg-slate-50">
                    <td class="py-3 text-slate-700">{{ $week['label'] }}</td>
                    <td class="py-3 text-right text-slate-700">{{ $week['workouts'] }}</td>
                    <td class="py-3 text-right text-slate-700">{{ number_format($week['steps']) }}</td>
                    <td class="py-3 text-right text-slate-700">{{ number_format($week['calories']) }}</td>
                    <td class="py-3 text-right text-slate-700">{{ $week['minutes'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
new Chart(document.getElementById('weeklyChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($weeks, 'label')) !!},
        datasets: [
            { label: 'Calories', data: {!! json_encode(array_column($weeks, 'calories')) !!}, backgroundColor: 'rgba(99,102,241,0.7)', borderRadius: 6 },
            { label: 'Steps',    data: {!! json_encode(array_column($weeks, 'steps')) !!},    backgroundColor: 'rgba(34,211,238,0.7)', borderRadius: 6, yAxisID: 'y1' },
        ]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true }, y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false } } } }
});

new Chart(document.getElementById('monthlyChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($months, 'label')) !!},
        datasets: [
            { label: 'Workouts', data: {!! json_encode(array_column($months, 'workouts')) !!}, borderColor: '#6366f1', backgroundColor: 'rgba(99,102,241,0.1)', tension: 0.4, fill: true },
            { label: 'Calories', data: {!! json_encode(array_column($months, 'calories')) !!}, borderColor: '#f97316', backgroundColor: 'rgba(249,115,22,0.1)',  tension: 0.4, fill: true, yAxisID: 'y1' },
        ]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true }, y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false } } } }
});
</script>
@endsection
