@extends('layouts.app')
@section('title', 'Profile')
@section('content')

<div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-slate-800 mb-6">👤 My Profile</h1>

    <div class="card">
        @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            {{-- Avatar --}}
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 rounded-2xl overflow-hidden bg-indigo-100 flex items-center justify-center flex-shrink-0">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover" id="avatarPreview">
                    @else
                        <span class="text-3xl font-bold text-indigo-600" id="avatarInitial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Profile Photo</label>
                    <input type="file" name="avatar" accept="image/*" class="text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-indigo-50 file:text-indigo-600 file:font-medium hover:file:bg-indigo-100">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="input">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="input">
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Age</label>
                    <input type="number" name="age" value="{{ old('age', $user->age) }}" min="5" max="120" class="input" placeholder="25">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Weight (kg)</label>
                    <input type="number" name="weight" value="{{ old('weight', $user->weight) }}" min="20" max="300" step="0.1" class="input" placeholder="70">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Height (cm)</label>
                    <input type="number" name="height" value="{{ old('height', $user->height) }}" min="50" max="250" step="0.1" class="input" placeholder="175">
                </div>
            </div>

            @if($user->weight && $user->height)
            @php $bmi = round($user->weight / (($user->height / 100) ** 2), 1); @endphp
            <div class="bg-indigo-50 rounded-xl px-4 py-3 text-sm text-indigo-700">
                <i class="fa-solid fa-circle-info mr-2"></i>
                BMI: <strong>{{ $bmi }}</strong> —
                {{ $bmi < 18.5 ? 'Underweight' : ($bmi < 25 ? 'Normal weight' : ($bmi < 30 ? 'Overweight' : 'Obese')) }}
            </div>
            @endif

            <hr class="border-slate-100">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">New Password <span class="text-slate-400">(leave blank to keep)</span></label>
                    <input type="password" name="password" class="input" placeholder="••••••••">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="input" placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="btn-primary w-full">Update Profile</button>
        </form>
    </div>
</div>
@endsection
