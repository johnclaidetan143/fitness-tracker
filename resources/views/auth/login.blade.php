@extends('layouts.guest')
@section('title', 'Login')
@section('content')
<h2 class="text-2xl font-bold text-slate-800 mb-6">Welcome back 👋</h2>

@if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium text-slate-600 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required
            class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-400 text-slate-700"
            placeholder="you@example.com">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-600 mb-1">Password</label>
        <input type="password" name="password" required
            class="w-full border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-400 text-slate-700"
            placeholder="••••••••">
    </div>
    <div class="flex items-center gap-2">
        <input type="checkbox" name="remember" id="remember" class="rounded">
        <label for="remember" class="text-sm text-slate-600">Remember me</label>
    </div>
    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold transition-all">
        Sign In
    </button>
</form>

<p class="text-center text-sm text-slate-500 mt-6">
    Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">Register</a>
</p>
@endsection
