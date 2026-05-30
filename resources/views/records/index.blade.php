@extends('layouts.app')
@section('title', 'Personal Records')
@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">🏆 Personal Records</h1>
    <p class="text-slate-500 text-sm mt-1">Your all-time best performances</p>
</div>

@php
$colorMap = [
    'indigo' => ['bg' => 'bg-indigo-100', 'text' => 'text-indigo-600', 'bar' => 'bg-indigo-500'],
    'orange' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-600', 'bar' => 'bg-orange-500'],
    'green'  => ['bg' => 'bg-green-100',  'text' => 'text-green-600',  'bar' => 'bg-green-500'],
    'cyan'   => ['bg' => 'bg-cyan-100',   'text' => 'text-cyan-600',   'bar' => 'bg-cyan-500'],
];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    @foreach($labels as $type => $info)
    @php
        $record = $records[$type] ?? null;
        $c = $colorMap[$info['color']];
    @endphp
    <div class="card">
        <div class="flex items-center gap-4">
            <div class="{{ $c['bg'] }} {{ $c['text'] }} w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid {{ $info['icon'] }} text-2xl"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm text-slate-500">{{ $info['label'] }}</p>
                @if($record)
                <p class="text-3xl font-bold text-slate-800">
                    {{ $info['unit'] === 'steps' ? number_format($record->value) : $record->value }}
                    <span class="text-base font-normal text-slate-400">{{ $info['unit'] }}</span>
                </p>
                <p class="text-xs text-slate-400 mt-1">Set on {{ $record->record_date->format('M d, Y') }}</p>
                @else
                <p class="text-2xl font-bold text-slate-300">—</p>
                <p class="text-xs text-slate-400 mt-1">No record yet</p>
                @endif
            </div>
            @if($record)
            <div class="text-4xl">🏆</div>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection
