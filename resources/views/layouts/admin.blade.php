<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitTracker Admin - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        .admin-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            padding: 24px;
        }

        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 12px;
            color: #cbd5e1;
            font-weight: 700;
            padding: 11px 14px;
            transition: background 0.2s, color 0.2s;
        }

        .admin-nav-link:hover,
        .admin-nav-link.active {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
        }

        .admin-table th,
        .admin-table td {
            padding: 14px 16px;
            white-space: nowrap;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <div class="flex min-h-screen">
        <aside class="fixed inset-y-0 left-0 hidden w-64 flex-col bg-slate-950 text-white lg:flex">
            <div class="border-b border-white/10 p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-lime-400 text-slate-950">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div>
                        <p class="text-lg font-black">FitTracker</p>
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Admin</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 space-y-2 p-4">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge-high w-5"></i>
                    Overview
                </a>
                <p class="px-3 pt-4 text-xs font-black uppercase tracking-widest text-slate-500">Records</p>
                <a href="{{ route('admin.users') }}" class="admin-nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="fa-solid fa-users w-5"></i>
                    Users
                </a>
                <a href="{{ route('admin.workouts') }}" class="admin-nav-link {{ request()->routeIs('admin.workouts') ? 'active' : '' }}">
                    <i class="fa-solid fa-dumbbell w-5"></i>
                    Workouts
                </a>
                <a href="{{ route('admin.meals') }}" class="admin-nav-link {{ request()->routeIs('admin.meals') ? 'active' : '' }}">
                    <i class="fa-solid fa-utensils w-5"></i>
                    Meals
                </a>
                <a href="{{ route('admin.water-logs') }}" class="admin-nav-link {{ request()->routeIs('admin.water-logs') ? 'active' : '' }}">
                    <i class="fa-solid fa-droplet w-5"></i>
                    Water Logs
                </a>
                <p class="px-3 pt-4 text-xs font-black uppercase tracking-widest text-slate-500">Insights</p>
                <a href="{{ route('admin.achievements') }}" class="admin-nav-link {{ request()->routeIs('admin.achievements') ? 'active' : '' }}">
                    <i class="fa-solid fa-medal w-5"></i>
                    Achievements
                </a>
                <a href="{{ route('admin.reports') }}" class="admin-nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line w-5"></i>
                    Reports
                </a>
                <p class="px-3 pt-4 text-xs font-black uppercase tracking-widest text-slate-500">Navigation</p>
                <a href="{{ route('dashboard') }}" class="admin-nav-link">
                    <i class="fa-solid fa-arrow-up-right-from-square w-5"></i>
                    User Dashboard
                </a>
            </nav>

            <div class="border-t border-white/10 p-4">
                <div class="mb-3 rounded-2xl bg-white/8 p-3">
                    <p class="text-sm font-bold">{{ Auth::user()->name }}</p>
                    <p class="truncate text-xs text-slate-400">{{ Auth::user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="admin-nav-link w-full text-left">
                        <i class="fa-solid fa-right-from-bracket w-5"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="min-w-0 flex-1 lg:ml-64">
            <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/85 px-5 py-4 backdrop-blur lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="lg:hidden">
                        <p class="text-lg font-black">FitTracker Admin</p>
                        <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="hidden lg:block">
                        <p class="text-sm font-bold uppercase tracking-widest text-slate-400">Administration</p>
                    </div>
                    <a href="{{ url('/') }}" class="rounded-full bg-slate-950 px-4 py-2 text-sm font-bold text-white transition hover:bg-slate-800">
                        Site
                    </a>
                </div>
            </header>

            <div class="p-5 lg:p-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
