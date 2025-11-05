<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SEMS') }} - Forgot Password</title>
    <link rel="icon" type="image/png" href="{{ asset('images/ub-logo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/ub-logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-stone-50 min-h-screen">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">

        <!-- Forgot Password Card -->
        <div class="px-8 py-10 bg-white shadow-md rounded-lg border border-gray-100">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-semibold text-gray-900">Forgot Password</h2>
                <p class="text-gray-600 mt-1">Enter your email address to receive a password reset link</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-3">
                        University Email
                    </label>
                    <div class="relative">
                        <svg class="absolute left-3 top-3.5 h-5 w-5 text-gray-500 pointer-events-none" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <input id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="email"
                            placeholder="staff@ubaguio.edu"
                            class="block w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150 ease-in-out">
                    </div>
                    @error('email')
                        <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mb-6">
                    <button type="submit" 
                            style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white; padding: 16px 24px; border-radius: 12px; border: none; font-weight: 600; font-size: 16px; width: 100%; transition: all 0.3s; cursor: pointer; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3); display: flex; align-items: center; justify-content: center; gap: 10px; transform: translateY(0);"
                            onmouseover="this.style.background='linear-gradient(135deg, #b91c1c 0%, #991b1b 100%)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 20px rgba(220, 38, 38, 0.4)'"
                            onmouseout="this.style.background='linear-gradient(135deg, #dc2626 0%, #b91c1c 100%)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 38, 38, 0.3)'">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>

                <!-- Back to Login -->
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm text-red-600 hover:text-red-500 transition-all duration-150 ease-in-out font-medium hover:underline">
                        ← Back to Login
                    </a>
                </div>
            </form>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Need an account? Contact our administrator<br>
                    sample@t.ubaguio.edu 
                </p>
                <p class="text-xs text-gray-400 mt-2">
                    Only @ubaguio.edu email addresses are allowed
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} University of Baguio. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
