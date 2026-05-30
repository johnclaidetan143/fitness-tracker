<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitnessTracker - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { primary: '#6366f1', accent: '#22d3ee' } } }
        }
    </script>
    <style>
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 12px;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.9rem;
            white-space: nowrap;
        }
        .sidebar-link:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .sidebar-link.active { background: rgba(255,255,255,0.2); color: #fff; font-weight: 600; }
        .sidebar-link i { width: 18px; text-align: center; flex-shrink: 0; }
        .card { background: #fff; border-radius: 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); padding: 24px; }
        .btn-primary { background: #6366f1; color: #fff; padding: 10px 20px; border-radius: 12px; font-weight: 500; border: none; cursor: pointer; transition: background 0.2s; text-decoration: none; display: inline-block; }
        .btn-primary:hover { background: #4f46e5; }
        .btn-danger { background: #ef4444; color: #fff; padding: 8px 16px; border-radius: 12px; font-weight: 500; border: none; cursor: pointer; transition: background 0.2s; }
        .btn-danger:hover { background: #dc2626; }
        .input { width: 100%; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 16px; outline: none; color: #334155; font-size: 0.95rem; transition: box-shadow 0.2s; }
        .input:focus { box-shadow: 0 0 0 3px rgba(99,102,241,0.25); border-color: #818cf8; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-56 min-h-screen bg-gradient-to-b from-indigo-700 to-indigo-900 flex flex-col fixed top-0 left-0 z-30" style="width:220px;height:100vh">
        <div class="p-6 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-dumbbell text-white"></i>
                </div>
                <span class="text-white font-bold text-lg">FitTracker</span>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-1" style="overflow-y:auto;max-height:calc(100vh - 180px)">
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <p style="font-size:10px;color:#94a3b8;padding:8px 14px 2px;text-transform:uppercase;letter-spacing:1px">Fitness</p>
            <a href="{{ route('workouts.index') }}" class="sidebar-link {{ request()->routeIs('workouts.*') ? 'active' : '' }}">
                <i class="fa-solid fa-dumbbell"></i> Workouts
            </a>
            <a href="{{ route('templates.index') }}" class="sidebar-link {{ request()->routeIs('templates.*') ? 'active' : '' }}">
                <i class="fa-solid fa-list-check"></i> Templates
            </a>
            <a href="{{ route('tutorials.index') }}" class="sidebar-link {{ request()->routeIs('tutorials.*') ? 'active' : '' }}">
                <i class="fa-solid fa-person-chalkboard"></i> Tutorials
            </a>
            <a href="{{ route('calendar.index') }}" class="sidebar-link {{ request()->routeIs('calendar.*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i> Calendar
            </a>
            <p style="font-size:10px;color:#94a3b8;padding:8px 14px 2px;text-transform:uppercase;letter-spacing:1px">Health</p>
            <a href="{{ route('meals.index') }}" class="sidebar-link {{ request()->routeIs('meals.*') ? 'active' : '' }}">
                <i class="fa-solid fa-utensils"></i> Meals
            </a>
            <a href="{{ route('water.index') }}" class="sidebar-link {{ request()->routeIs('water.*') ? 'active' : '' }}">
                <i class="fa-solid fa-droplet"></i> Water
            </a>
            <a href="{{ route('sleep.index') }}" class="sidebar-link {{ request()->routeIs('sleep.*') ? 'active' : '' }}">
                <i class="fa-solid fa-moon"></i> Sleep
            </a>
            <p style="font-size:10px;color:#94a3b8;padding:8px 14px 2px;text-transform:uppercase;letter-spacing:1px">Analytics</p>
            <a href="{{ route('progress.index') }}" class="sidebar-link {{ request()->routeIs('progress.*') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Progress
            </a>
            <a href="{{ route('reports.index') }}" class="sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-bar"></i> Reports
            </a>
            <a href="{{ route('records.index') }}" class="sidebar-link {{ request()->routeIs('records.*') ? 'active' : '' }}">
                <i class="fa-solid fa-trophy"></i> Records
            </a>
            <a href="{{ route('achievements.index') }}" class="sidebar-link {{ request()->routeIs('achievements.*') ? 'active' : '' }}">
                <i class="fa-solid fa-medal"></i> Achievements
            </a>
            <p style="font-size:10px;color:#94a3b8;padding:8px 14px 2px;text-transform:uppercase;letter-spacing:1px">Settings</p>
            <a href="{{ route('goals.edit') }}" class="sidebar-link {{ request()->routeIs('goals.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bullseye"></i> Goals
            </a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fa-solid fa-user"></i> Profile
            </a>
        </nav>

        <div class="p-4 border-t border-white/10">
            <div class="flex items-center gap-3 mb-3">
                @if(Auth::user()->avatar)
                    <img src="{{ Storage::url(Auth::user()->avatar) }}" class="w-9 h-9 rounded-full object-cover">
                @else
                    <div class="w-9 h-9 bg-white/20 rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <p class="text-white text-sm font-medium">{{ Auth::user()->name }}</p>
                    <p class="text-indigo-300 text-xs">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left sidebar-link text-sm">
                    <i class="fa-solid fa-right-from-bracket w-5"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 p-8" style="margin-left:220px">
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </main>

</body>
</html>
