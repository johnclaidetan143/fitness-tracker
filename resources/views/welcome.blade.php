<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitTracker - Your Personal Fitness Companion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        :root {
            --ink: #111827;
            --electric: #16a34a;
            --pulse: #f97316;
            --sky: #0ea5e9;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: #f8fafc;
        }

        .hero-photo {
            background-image:
                linear-gradient(90deg, rgba(5, 10, 23, 0.92) 0%, rgba(5, 10, 23, 0.74) 44%, rgba(5, 10, 23, 0.26) 100%),
                url('{{ asset('images/workout.jpg') }}');
            background-position: center;
            background-size: cover;
        }

        .nav-glass {
            background: rgba(248, 250, 252, 0.86);
            box-shadow: 0 18px 60px rgba(15, 23, 42, 0.08);
        }

        .load-in {
            animation: riseIn 0.8s ease both;
        }

        .load-in-delay-1 {
            animation-delay: 0.12s;
        }

        .load-in-delay-2 {
            animation-delay: 0.24s;
        }

        .load-in-delay-3 {
            animation-delay: 0.36s;
        }

        .float-card {
            animation: floatCard 5.5s ease-in-out infinite;
        }

        .metric-fill {
            transform-origin: left;
            animation: fillBar 1.4s 0.65s cubic-bezier(.2,.8,.2,1) both;
        }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .feature-tile {
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .feature-tile:hover {
            transform: translateY(-6px);
            border-color: rgba(22, 163, 74, 0.35);
            box-shadow: 0 20px 45px rgba(15, 23, 42, 0.10);
        }

        @keyframes riseIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatCard {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-12px);
            }
        }

        @keyframes fillBar {
            from {
                transform: scaleX(0);
            }
            to {
                transform: scaleX(1);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
            }

            .reveal {
                opacity: 1;
                transform: none;
            }
        }
    </style>
</head>
<body class="text-slate-900 antialiased">

    <nav class="nav-glass fixed top-0 z-50 w-full border-b border-white/70 backdrop-blur-xl">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 sm:px-6 lg:px-8">
            <a href="{{ url('/') }}" class="flex items-center gap-3" aria-label="FitTracker home">
                <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-950 text-white shadow-lg shadow-slate-900/10">
                    <i class="fa-solid fa-dumbbell text-sm"></i>
                </span>
                <span class="text-xl font-black tracking-tight">FitTracker</span>
            </a>

            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('login') }}" class="rounded-full px-4 py-2 text-sm font-bold text-slate-700 transition hover:bg-slate-900/5 hover:text-slate-950">Log in</a>
                <a href="{{ route('register') }}" class="rounded-full bg-lime-500 px-5 py-2.5 text-sm font-black text-slate-950 shadow-lg shadow-lime-500/25 transition hover:-translate-y-0.5 hover:bg-lime-400">Get Started</a>
            </div>
        </div>
    </nav>

    <main>
        <section class="hero-photo relative flex min-h-[92vh] items-center overflow-hidden pt-24 text-white">
            <div class="mx-auto grid w-full max-w-7xl items-center gap-10 px-5 pb-16 pt-10 sm:px-6 lg:grid-cols-[1.08fr_0.92fr] lg:px-8">
                <div class="max-w-3xl">
                    <div class="load-in inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-black uppercase tracking-[0.22em] text-lime-200 backdrop-blur">
                        <i class="fa-solid fa-bolt"></i>
                        Train smarter every week
                    </div>

                    <h1 class="load-in load-in-delay-1 mt-7 text-5xl font-black leading-[0.96] tracking-tight sm:text-6xl lg:text-7xl">
                        Build the body of data behind every rep.
                    </h1>

                    <p class="load-in load-in-delay-2 mt-6 max-w-2xl text-lg leading-8 text-slate-200 sm:text-xl">
                        Track workouts, meals, water, sleep, goals, records, and progress in one focused fitness dashboard.
                    </p>

                    <div class="load-in load-in-delay-3 mt-9 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-lime-400 px-7 py-4 text-base font-black text-slate-950 shadow-2xl shadow-lime-500/25 transition hover:-translate-y-1 hover:bg-lime-300">
                            Start for Free
                            <i class="fa-solid fa-arrow-right text-sm"></i>
                        </a>
                        <a href="#features" class="inline-flex items-center justify-center gap-2 rounded-full border border-white/25 bg-white/10 px-7 py-4 text-base font-black text-white backdrop-blur transition hover:-translate-y-1 hover:bg-white/20">
                            Explore Features
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </a>
                    </div>
                </div>

                <div class="load-in load-in-delay-3 hidden lg:block">
                    <div class="float-card ml-auto max-w-md rounded-[2rem] border border-white/18 bg-slate-950/72 p-5 shadow-2xl shadow-black/35 backdrop-blur-xl">
                        <div class="mb-5 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-bold text-slate-300">Today's Training</p>
                                <p class="text-2xl font-black">Push Strength</p>
                            </div>
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-lime-400 text-slate-950">
                                <i class="fa-solid fa-fire-flame-curved"></i>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="rounded-2xl bg-white/10 p-4">
                                <div class="mb-2 flex items-center justify-between text-sm">
                                    <span class="font-bold text-slate-200">Workout goal</span>
                                    <span class="font-black text-lime-300">82%</span>
                                </div>
                                <div class="h-3 overflow-hidden rounded-full bg-white/10">
                                    <div class="metric-fill h-full w-[82%] rounded-full bg-lime-400"></div>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-3">
                                <div class="rounded-2xl bg-white p-4 text-slate-950">
                                    <p class="text-2xl font-black">12</p>
                                    <p class="text-xs font-bold text-slate-500">Sets</p>
                                </div>
                                <div class="rounded-2xl bg-sky-400 p-4 text-slate-950">
                                    <p class="text-2xl font-black">2.4L</p>
                                    <p class="text-xs font-bold text-slate-800">Water</p>
                                </div>
                                <div class="rounded-2xl bg-orange-400 p-4 text-slate-950">
                                    <p class="text-2xl font-black">7h</p>
                                    <p class="text-xs font-bold text-slate-800">Sleep</p>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-white/10 p-4">
                                <div class="mb-3 flex items-center gap-3">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-lime-300">
                                        <i class="fa-solid fa-trophy"></i>
                                    </span>
                                    <div>
                                        <p class="font-black">New personal record</p>
                                        <p class="text-sm text-slate-400">Bench press up by 5kg</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <span class="h-2 flex-1 rounded-full bg-lime-400"></span>
                                    <span class="h-2 flex-1 rounded-full bg-sky-400"></span>
                                    <span class="h-2 flex-1 rounded-full bg-orange-400"></span>
                                    <span class="h-2 flex-1 rounded-full bg-white/20"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="-mt-10 px-5 sm:px-6 lg:px-8">
            <div class="mx-auto grid max-w-6xl gap-4 rounded-[2rem] border border-slate-200 bg-white p-4 shadow-xl shadow-slate-900/8 sm:grid-cols-3">
                <div class="reveal rounded-3xl bg-slate-950 p-6 text-white">
                    <p class="text-4xl font-black">10+</p>
                    <p class="mt-1 text-sm font-bold text-slate-300">Connected fitness tools</p>
                </div>
                <div class="reveal rounded-3xl bg-lime-400 p-6 text-slate-950">
                    <p class="text-4xl font-black">24/7</p>
                    <p class="mt-1 text-sm font-bold">Access from your dashboard</p>
                </div>
                <div class="reveal rounded-3xl bg-sky-400 p-6 text-slate-950">
                    <p class="text-4xl font-black">100%</p>
                    <p class="mt-1 text-sm font-bold">Free to start tracking</p>
                </div>
            </div>
        </section>

        <section id="features" class="py-24">
            <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
                <div class="reveal max-w-2xl">
                    <p class="text-sm font-black uppercase tracking-[0.22em] text-lime-600">Your fitness command center</p>
                    <h2 class="mt-4 text-4xl font-black tracking-tight text-slate-950 sm:text-5xl">Every habit, lift, meal, and milestone in one place.</h2>
                </div>

                <div class="mt-12 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach([
                        ['fa-dumbbell', 'bg-lime-100 text-lime-700', 'Workouts', 'Log exercises, sets, reps, notes, and workout templates.'],
                        ['fa-utensils', 'bg-orange-100 text-orange-700', 'Meal Tracking', 'Track calories and macros that support your training.'],
                        ['fa-droplet', 'bg-sky-100 text-sky-700', 'Water Intake', 'Keep hydration visible with simple daily water logs.'],
                        ['fa-moon', 'bg-indigo-100 text-indigo-700', 'Sleep Logs', 'Monitor recovery patterns so your training stays sustainable.'],
                        ['fa-chart-line', 'bg-emerald-100 text-emerald-700', 'Progress Reports', 'Review charts, reports, streaks, and training trends.'],
                        ['fa-calendar-days', 'bg-cyan-100 text-cyan-700', 'Calendar', 'See your complete fitness history in a weekly and monthly view.'],
                        ['fa-trophy', 'bg-amber-100 text-amber-700', 'Personal Records', 'Capture your best performances and celebrate new PRs.'],
                        ['fa-medal', 'bg-violet-100 text-violet-700', 'Achievements', 'Earn badges for consistency, milestones, and momentum.'],
                    ] as [$icon, $color, $title, $desc])
                    <article class="feature-tile reveal rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl {{ $color }}">
                            <i class="fa-solid {{ $icon }}"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-950">{{ $title }}</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ $desc }}</p>
                    </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="bg-slate-950 px-5 py-20 text-white sm:px-6 lg:px-8">
            <div class="reveal mx-auto flex max-w-6xl flex-col items-start justify-between gap-8 lg:flex-row lg:items-center">
                <div class="max-w-2xl">
                    <p class="text-sm font-black uppercase tracking-[0.22em] text-lime-300">Ready when you are</p>
                    <h2 class="mt-4 text-4xl font-black tracking-tight sm:text-5xl">Start tracking today and make progress easier to see.</h2>
                </div>
                <a href="{{ route('register') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-lime-400 px-8 py-4 text-base font-black text-slate-950 shadow-xl shadow-lime-500/20 transition hover:-translate-y-1 hover:bg-lime-300">
                    Create Free Account
                    <i class="fa-solid fa-arrow-right text-sm"></i>
                </a>
            </div>
        </section>
    </main>

    <footer class="bg-white px-5 py-8 text-sm text-slate-500 sm:px-6 lg:px-8">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 sm:flex-row">
            <div class="flex items-center gap-2">
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-slate-950 text-white">
                    <i class="fa-solid fa-dumbbell text-xs"></i>
                </span>
                <span class="font-black text-slate-950">FitTracker</span>
            </div>
            <p>&copy; {{ date('Y') }} FitTracker. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.16 });

        document.querySelectorAll('.reveal').forEach((element) => observer.observe(element));
    </script>
</body>
</html>
