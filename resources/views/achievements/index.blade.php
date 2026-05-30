@extends('layouts.app')
@section('title', 'Achievements')
@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">🏅 Achievements</h1>
    <p class="text-slate-500 text-sm mt-1">{{ $earned->count() }} / {{ $all->count() }} earned</p>
</div>

@php
$colorMap = [
    'indigo'  => ['bg' => 'bg-indigo-100',  'text' => 'text-indigo-600'],
    'orange'  => ['bg' => 'bg-orange-100',  'text' => 'text-orange-600'],
    'red'     => ['bg' => 'bg-red-100',     'text' => 'text-red-600'],
    'yellow'  => ['bg' => 'bg-yellow-100',  'text' => 'text-yellow-600'],
    'green'   => ['bg' => 'bg-green-100',   'text' => 'text-green-600'],
    'teal'    => ['bg' => 'bg-teal-100',    'text' => 'text-teal-600'],
    'cyan'    => ['bg' => 'bg-cyan-100',    'text' => 'text-cyan-600'],
    'purple'  => ['bg' => 'bg-purple-100',  'text' => 'text-purple-600'],
    'blue'    => ['bg' => 'bg-blue-100',    'text' => 'text-blue-600'],
];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
    @foreach($all as $a)
    @php
        $isEarned = isset($earned[$a->key]);
        $c = $colorMap[$a->color] ?? $colorMap['indigo'];
    @endphp
    <div class="card flex items-center gap-4 {{ !$isEarned ? 'opacity-50' : '' }}">
        <div class="w-14 h-14 {{ $isEarned ? $c['bg'] : 'bg-slate-100' }} rounded-2xl flex items-center justify-center flex-shrink-0">
            <i class="fa-solid {{ $a->icon }} text-2xl {{ $isEarned ? $c['text'] : 'text-slate-400' }}"></i>
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2">
                <p class="font-bold text-slate-800">{{ $a->name }}</p>
                @if($isEarned)<span class="text-xs bg-green-100 text-green-600 px-2 py-0.5 rounded-full">✓ Earned</span>@endif
            </div>
            <p class="text-sm text-slate-500 mt-0.5">{{ $a->description }}</p>
            @if($isEarned && $earned[$a->key]->pivot->earned_at)
            <p class="text-xs text-slate-400 mt-1">{{ \Carbon\Carbon::parse($earned[$a->key]->pivot->earned_at)->format('M d, Y') }}</p>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection
