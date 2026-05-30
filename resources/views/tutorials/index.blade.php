@extends('layouts.app')
@section('title', 'Exercise Tutorials')
@section('content')

<div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Exercise Tutorials</h1>
        <p class="text-slate-500 text-sm mt-1">Learn proper form before adding exercises to your workouts.</p>
    </div>
    <a href="{{ route('workouts.create') }}" class="btn-primary inline-flex items-center justify-center gap-2">
        <i class="fa-solid fa-plus"></i> Log Workout
    </a>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
    @foreach($tutorials as $tutorial)
    <article class="card flex flex-col gap-5">
        <div class="flex items-start gap-4">
            <div class="w-14 h-14 {{ $tutorial['color'] }} rounded-2xl flex items-center justify-center flex-shrink-0">
                <i class="fa-solid {{ $tutorial['icon'] }} text-2xl"></i>
            </div>
            <div class="min-w-0">
                <h2 class="font-bold text-slate-800 text-lg">{{ $tutorial['name'] }}</h2>
                <div class="flex flex-wrap items-center gap-2 mt-1">
                    <span class="text-xs font-medium px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full">{{ $tutorial['type'] }}</span>
                    <span class="text-xs font-medium px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full">{{ $tutorial['level'] }}</span>
                    <span class="text-xs text-slate-400">{{ $tutorial['minutes'] }} min guide</span>
                </div>
            </div>
        </div>

        <div class="bg-slate-50 rounded-xl p-4">
            <p class="text-xs uppercase tracking-wide text-slate-400 font-bold mb-1">Focus</p>
            <p class="text-sm text-slate-600 leading-relaxed">{{ $tutorial['focus'] }}</p>
        </div>

        <div class="tutorial-video group rounded-xl overflow-hidden bg-black h-56 flex items-center justify-center relative">
            <video class="absolute inset-0 w-full h-full object-contain" preload="auto" playsinline muted loop autoplay controls>
                <source src="{{ $tutorial['video_url'] }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="video-overlay absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/75 to-transparent transition-opacity pointer-events-none"></div>
            <button type="button"
                class="video-overlay absolute inset-0 flex items-end justify-center px-5 py-5 transition-opacity"
                aria-label="Play {{ $tutorial['name'] }} video">
                <div class="flex items-center gap-3 rounded-full bg-black/55 border border-white/20 px-4 py-2 text-white shadow-lg group-hover:bg-black/70 transition-colors">
                    <span class="w-9 h-9 rounded-full bg-white text-slate-900 flex items-center justify-center group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-volume-high text-sm"></i>
                    </span>
                    <span class="text-left">
                        <span class="block font-bold text-sm">Play with sound</span>
                        <span class="block text-white/75 text-xs">Preview is already visible</span>
                    </span>
                </div>
            </button>
        </div>

        <div>
            <h3 class="font-bold text-slate-700 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-list-ol text-indigo-500"></i> How to do it
            </h3>
            <ol class="space-y-3">
                @foreach($tutorial['steps'] as $step)
                <li class="flex gap-3 text-sm text-slate-600 leading-relaxed">
                    <span class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 font-bold text-xs flex items-center justify-center flex-shrink-0">{{ $loop->iteration }}</span>
                    <span>{{ $step }}</span>
                </li>
                @endforeach
            </ol>
        </div>

        <div class="border-t border-slate-100 pt-4 mt-auto">
            <h3 class="font-bold text-slate-700 mb-2 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-emerald-500"></i> Form tips
            </h3>
            <ul class="space-y-2">
                @foreach($tutorial['tips'] as $tip)
                <li class="flex gap-2 text-sm text-slate-500 leading-relaxed">
                    <i class="fa-solid fa-check text-emerald-500 text-xs mt-1"></i>
                    <span>{{ $tip }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </article>
    @endforeach
</div>

<script>
    document.querySelectorAll('.tutorial-video').forEach((player) => {
        const video = player.querySelector('video');
        const overlays = player.querySelectorAll('.video-overlay');
        const playButton = player.querySelector('button');

        playButton.addEventListener('click', () => {
            overlays.forEach((overlay) => overlay.classList.add('opacity-0'));
            playButton.classList.add('pointer-events-none');
            video.muted = false;
            video.currentTime = 0;
            video.play();
        });

        video.addEventListener('play', () => {
            if (!video.muted) {
                overlays.forEach((overlay) => overlay.classList.add('opacity-0'));
                playButton.classList.add('pointer-events-none');
            }
        });

        video.addEventListener('ended', () => {
            overlays.forEach((overlay) => overlay.classList.remove('opacity-0'));
            playButton.classList.remove('pointer-events-none');
        });

        video.addEventListener('pause', () => {
            if (video.currentTime === 0 || video.ended) {
                overlays.forEach((overlay) => overlay.classList.remove('opacity-0'));
                playButton.classList.remove('pointer-events-none');
            }
        });
    });
</script>

@endsection
