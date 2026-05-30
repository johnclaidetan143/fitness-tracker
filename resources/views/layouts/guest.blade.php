<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - FitTracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-2xl mb-4">
                <i class="fa-solid fa-dumbbell text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-white">FitTracker</h1>
            <p class="text-white/70 mt-1">Your personal fitness companion</p>
        </div>
        <div class="bg-white rounded-3xl shadow-2xl p-8">
            @yield('content')
        </div>
    </div>
</body>
</html>
