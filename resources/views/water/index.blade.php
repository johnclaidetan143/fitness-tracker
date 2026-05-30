@extends('layouts.app')
@section('title', 'Water Intake')
@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">💧 Water Intake</h1>
    <p class="text-slate-500 text-sm mt-1">Stay hydrated! Goal: {{ $goals->daily_water_glasses }} glasses/day</p>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    {{-- Today's Progress --}}
    <div class="card xl:col-span-1">
        @php $pct = $goals->daily_water_glasses > 0 ? min(100, round($todayGlasses / $goals->daily_water_glasses * 100)) : 0; @endphp
        <h2 class="font-bold text-slate-800 mb-4">Today's Progress</h2>

        <div class="flex items-center justify-center mb-6">
            <div class="relative w-36 h-36">
                <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">
                    <circle cx="60" cy="60" r="50" fill="none" stroke="#e2e8f0" stroke-width="12"/>
                    <circle cx="60" cy="60" r="50" fill="none" stroke="#06b6d4" stroke-width="12"
                        stroke-dasharray="{{ round(314 * $pct / 100) }} 314"
                        stroke-linecap="round"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-3xl font-bold text-slate-800">{{ $todayGlasses }}</span>
                    <span class="text-xs text-slate-400">/ {{ $goals->daily_water_glasses }}</span>
                    <span class="text-xs text-cyan-600 font-medium">{{ $pct }}%</span>
                </div>
            </div>
        </div>

        {{-- Glass indicators --}}
        <div class="grid grid-cols-4 gap-2 mb-6">
            @for($i = 1; $i <= $goals->daily_water_glasses; $i++)
            <div class="flex flex-col items-center">
                <i class="fa-solid fa-glass-water text-xl {{ $i <= $todayGlasses ? 'text-cyan-500' : 'text-slate-200' }}"></i>
            </div>
            @endfor
        </div>

        <form method="POST" action="{{ route('water.store') }}">
            @csrf
            <div class="flex gap-2">
                <input type="number" name="glasses" value="1" min="1" max="20" class="input text-center">
                <button type="submit" class="btn-primary whitespace-nowrap">
                    <i class="fa-solid fa-plus mr-1"></i> Add
                </button>
            </div>
        </form>

        @if($pct >= 100)
        <div class="mt-4 bg-cyan-50 border border-cyan-200 text-cyan-700 px-4 py-3 rounded-xl text-sm text-center">
            🎉 Daily goal achieved!
        </div>
        @endif
    </div>

    {{-- Recent Logs --}}
    <div class="card xl:col-span-2">
        <h2 class="font-bold text-slate-800 mb-4">Recent Logs</h2>
        @forelse($logs as $log)
        <div class="flex items-center gap-4 py-3 border-b border-slate-100 last:border-0">
            <div class="w-10 h-10 bg-cyan-100 rounded-xl flex items-center justify-center">
                <i class="fa-solid fa-droplet text-cyan-600"></i>
            </div>
            <div class="flex-1">
                <p class="font-medium text-slate-700">{{ $log->glasses }} glass{{ $log->glasses > 1 ? 'es' : '' }}</p>
                <p class="text-xs text-slate-400">{{ $log->ml }} ml · {{ $log->log_date->format('M d, Y') }}</p>
            </div>
            <form method="POST" action="{{ route('water.destroy', $log) }}">
                @csrf @method('DELETE')
                <button class="text-slate-300 hover:text-red-500 transition-colors p-1">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </form>
        </div>
        @empty
        <div class="text-center py-12 text-slate-400">
            <i class="fa-solid fa-droplet text-4xl mb-2 block"></i>
            <p class="text-sm">No water logs yet</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
