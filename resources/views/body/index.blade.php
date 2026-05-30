@extends('layouts.app')
@section('title', 'Body & BMI')
@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">⚖️ Body & BMI Tracker</h1>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    {{-- Log BMI --}}
    <div class="space-y-5">
        <div class="card">
            <h2 class="font-bold text-slate-800 mb-4">Log BMI</h2>
            <form method="POST" action="{{ route('body.bmi.store') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Weight (kg)</label>
                    <input type="number" name="weight" step="0.1" value="{{ $user->weight }}" required class="input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Height (cm)</label>
                    <input type="number" name="height" step="0.1" value="{{ $user->height }}" required class="input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Date</label>
                    <input type="date" name="log_date" value="{{ now()->toDateString() }}" required class="input">
                </div>
                <button type="submit" class="btn-primary w-full">Log BMI</button>
            </form>
        </div>

        {{-- Current BMI Card --}}
        @if($currentBmi)
        @php
            $bmiCategory = $currentBmi < 18.5 ? ['label'=>'Underweight','color'=>'text-blue-600','bg'=>'bg-blue-50']
                : ($currentBmi < 25 ? ['label'=>'Normal','color'=>'text-green-600','bg'=>'bg-green-50']
                : ($currentBmi < 30 ? ['label'=>'Overweight','color'=>'text-orange-600','bg'=>'bg-orange-50']
                : ['label'=>'Obese','color'=>'text-red-600','bg'=>'bg-red-50']));
        @endphp
        <div class="card text-center {{ $bmiCategory['bg'] }}">
            <p class="text-sm text-slate-500 mb-1">Current BMI</p>
            <p class="text-5xl font-bold {{ $bmiCategory['color'] }}">{{ $currentBmi }}</p>
            <p class="font-semibold {{ $bmiCategory['color'] }} mt-1">{{ $bmiCategory['label'] }}</p>
            <div class="mt-3 text-xs text-slate-500 space-y-1">
                <p>Underweight: &lt; 18.5</p>
                <p>Normal: 18.5 – 24.9</p>
                <p>Overweight: 25 – 29.9</p>
                <p>Obese: ≥ 30</p>
            </div>
        </div>
        @endif

        {{-- Body Measurements Form --}}
        <div class="card">
            <h2 class="font-bold text-slate-800 mb-4">Body Measurements (cm)</h2>
            <form method="POST" action="{{ route('body.measurements.store') }}" class="space-y-3">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    @foreach(['waist'=>'Waist','chest'=>'Chest','arms'=>'Arms','legs'=>'Legs','hips'=>'Hips','neck'=>'Neck'] as $field => $label)
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">{{ $label }}</label>
                        <input type="number" name="{{ $field }}" step="0.1" min="0"
                            value="{{ $latest?->$field }}" class="input" placeholder="cm">
                    </div>
                    @endforeach
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Date</label>
                    <input type="date" name="measured_date" value="{{ now()->toDateString() }}" required class="input">
                </div>
                <button type="submit" class="btn-primary w-full">Save Measurements</button>
            </form>
        </div>
    </div>

    {{-- BMI Chart + History --}}
    <div class="xl:col-span-2 space-y-5">
        @if($bmiLogs->count() > 1)
        <div class="card">
            <h2 class="font-bold text-slate-800 mb-4">BMI History Chart</h2>
            <canvas id="bmiChart" height="100"></canvas>
        </div>
        @endif

        {{-- Measurements History --}}
        @if($measurements->count() > 0)
        <div class="card">
            <h2 class="font-bold text-slate-800 mb-4">Measurements History</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-500 text-xs">
                            <th class="text-left py-2">Date</th>
                            <th class="text-right py-2">Waist</th>
                            <th class="text-right py-2">Chest</th>
                            <th class="text-right py-2">Arms</th>
                            <th class="text-right py-2">Legs</th>
                            <th class="text-right py-2">Hips</th>
                            <th class="text-right py-2">Neck</th>
                            <th class="py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($measurements as $m)
                        <tr class="border-b border-slate-50 hover:bg-slate-50">
                            <td class="py-2 text-slate-700">{{ $m->measured_date->format('M d, Y') }}</td>
                            @foreach(['waist','chest','arms','legs','hips','neck'] as $f)
                            <td class="py-2 text-right text-slate-600">{{ $m->$f ?? '—' }}</td>
                            @endforeach
                            <td class="py-2 text-right">
                                <form method="POST" action="{{ route('body.measurements.destroy', $m) }}">
                                    @csrf @method('DELETE')
                                    <button class="text-red-400 hover:text-red-600 text-xs">delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- BMI Log Table --}}
        @if($bmiLogs->count() > 0)
        <div class="card">
            <h2 class="font-bold text-slate-800 mb-4">BMI Log</h2>
            <div class="space-y-2">
                @foreach($bmiLogs->sortByDesc('log_date')->take(10) as $log)
                <div class="flex items-center justify-between py-2 border-b border-slate-50">
                    <span class="text-sm text-slate-500">{{ $log->log_date->format('M d, Y') }}</span>
                    <span class="text-sm text-slate-600">{{ $log->weight }}kg / {{ $log->height }}cm</span>
                    <span class="font-bold text-indigo-600">BMI {{ $log->bmi }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@if($bmiLogs->count() > 1)
<script>
new Chart(document.getElementById('bmiChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: {!! json_encode($bmiLogs->pluck('log_date')->map(fn($d) => $d->format('M d'))->toArray()) !!},
        datasets: [{
            label: 'BMI',
            data: {!! json_encode($bmiLogs->pluck('bmi')->toArray()) !!},
            borderColor: '#6366f1',
            backgroundColor: 'rgba(99,102,241,0.1)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#6366f1',
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: false, min: 10, title: { display: true, text: 'BMI' } }
        }
    }
});
</script>
@endif
@endsection
