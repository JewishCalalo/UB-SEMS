<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SEMS - Too Many Requests</title>
    @vite([
        'resources/js/app.js',
        'resources/css/app.css'
    ])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/ub-logo.png') }}">
</head>
<body class="font-sans antialiased min-h-screen" style="background-image: url('{{ asset('images/Background.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">
    <x-welcome-navigation/>
    <div class="min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 py-10 relative">
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        <div class="relative z-10 w-full max-w-xl bg-white/95 backdrop-blur rounded-xl shadow-lg border border-gray-100 p-8 text-center">
            <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h1 class="text-2xl font-semibold text-gray-900 mb-2">Too Many Requests (429)</h1>
            <p class="text-gray-600 mb-6">You’ve made too many requests in a short time. Please wait a moment and try again.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('welcome') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg text-white" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);">
                    Go to Home
                </a>
                <button onclick="window.location.reload()" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 bg-white hover:bg-gray-50">
                    Retry
                </button>
            </div>
        </div>
    </div>
</body>
</html>


