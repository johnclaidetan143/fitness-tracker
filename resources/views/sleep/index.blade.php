@extends('layouts.app')
@section('title', 'Sleep Tracker')
@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">😴 Sleep Tracker</h1>
    <p class="text-slate-500 text-sm mt-1">Recommended: 7–9 hours per night</p>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    {{-- Log Sleep --}}
    <div class="card">
        <h2 class="font-bold text-slate-800 mb-4">Log Sleep</h2>
        <form method="POST" action="{{ route('sleep.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Hours Slept</label>
                <input type="number" name="hours" step="0.5" min="0.5" max="24"
                    value="{{ $todayLog?->hours ?? 7 }}" required class="input">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-2">Sleep Quality</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach(['poor'=>['😴','Poor','red'],'fair'=>['😐','Fair','yellow'],'good'=>['🙂','Good','green'],'excellent'=>['😁','Excellent','indigo']] as $val => $info)
                    <label class="cursor-pointer">
                        <input type="radio" name="quality" value="{{ $val }}" class="sr-only"
                            {{ ($todayLog?->quality ?? 'good') === $val ? 'checked' : '' }}>
                        <div class="quality-card border-2 rounded-xl p-2 text-center transition-all
                            {{ ($todayLog?->quality ?? 'good') === $val ? 'border-indigo-500 bg-indigo-50' : 'border-slate-200' }}">
                            <span class="text-xl block">{{ $info[0] }}</span>
                            <span class="text-xs font-medium text-slate-600">{{ $info[1] }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Date</label>
                <input type="date" name="sleep_date" value="{{ now()->toDateString() }}" required class="input">
            </div>
            <button type="submit" class="btn-primary w-full">Log Sleep</button>
        </form>

        {{-- Stats --}}
        <div class="mt-5 pt-4 border-t border-slate-100 grid grid-cols-2 gap-3 text-center">
            <div class="bg-indigo-50 rounded-xl p-3">
                <p class="text-2xl font-bold text-indigo-600">{{ number_format($avgHours, 1) }}</p>
                <p class="text-xs text-slate-500">Avg Hours</p>
            </div>
            <div class="bg-green-50 rounded-xl p-3">
                <p class="text-2xl font-bold text-green-600">{{ $todayLog?->hours ?? '—' }}</p>
                <p class="text-xs text-slate-500">Last Night</p>
            </div>
        </div>
    </div>

    {{-- Chart + Log --}}
    <div class="xl:col-span-2 space-y-5">
        <div class="card">
            <h2 class="font-bold text-slate-800 mb-4">Last 7 Days</h2>
            <canvas id="sleepChart" height="100"></canvas>
        </div>

        <div class="card">
            <h2 class="font-bold text-slate-800 mb-4">Sleep History</h2>
            @forelse($logs as $log)
            <div class="flex items-center gap-3 py-3 border-b border-slate-100 last:border-0">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-lg">
                    {{ $log->quality === 'excellent' ? '😁' : ($log->quality === 'good' ? '🙂' : ($log->quality === 'fair' ? '😐' : '😴')) }}
                </div>
                <div class="flex-1">
                    <p class="font-medium text-slate-700">{{ $log->hours }} hours</p>
                    <p class="text-xs text-slate-400">{{ ucfirst($log->quality) }} · {{ $log->sleep_date->format('M d, Y') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    @php $pct = min(100, round($log->hours / 9 * 100)); @endphp
                    <div class="w-20 bg-slate-100 rounded-full h-2">
                        <div class="{{ $log->hours >= 7 ? 'bg-green-500' : ($log->hours >= 5 ? 'bg-yellow-500' : 'bg-red-500') }} h-2 rounded-full" style="width:{{ $pct }}%"></div>
                    </div>
                    <form method="POST" action="{{ route('sleep.destroy', $log) }}">
                        @csrf @method('DELETE')
                        <button class="text-slate-300 hover:text-red-500 p-1"><i class="fa-solid fa-xmark text-xs"></i></button>
                    </form>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-slate-400">
                <p class="text-sm">No sleep logs yet</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
new Chart(document.getElementById('sleepChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($weeklyData, 'date')) !!},
        datasets: [{
            label: 'Hours',
            data: {!! json_encode(array_column($weeklyData, 'hours')) !!},
            backgroundColor: data => data.raw >= 7 ? 'rgba(99,102,241,0.7)' : 'rgba(249,115,22,0.7)',
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, max: 12, title: { display: true, text: 'Hours' } }
        }
    }
});

document.querySelectorAll('input[name="quality"]').forEach(r => {
    r.addEventListener('change', () => {
        document.querySelectorAll('.quality-card').forEach(c => c.classList.remove('border-indigo-500','bg-indigo-50'));
        r.nextElementSibling.classList.add('border-indigo-500','bg-indigo-50');
    });
});
</script>
@endsection
