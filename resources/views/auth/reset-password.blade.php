<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SEMS') }} - Reset Password</title>
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

        <!-- Reset Password Card -->
        <div class="px-8 py-10 bg-white shadow-md rounded-lg border border-gray-100">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-semibold text-gray-900">Reset Password</h2>
                <p class="text-gray-600 mt-1">Enter your new password below</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                            value="{{ old('email', $request->email) }}" 
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="staff@ubaguio.edu"
                            class="block w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150 ease-in-out">
                    </div>
                    @error('email')
                        <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-3">
                        New Password
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
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v2h8z">
                            </path>
                        </svg>
                        <input id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="new-password"
                            placeholder="Enter new password"
                            class="block w-full pl-11 pr-12 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150 ease-in-out">
                        <button type="button" 
                            id="password-toggle"
                            class="absolute inset-y-0 right-0 my-1 mr-1 inline-flex items-center justify-center w-10 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <svg id="password-eye" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg id="password-eye-slash" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-3">
                        Confirm New Password
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
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v2h8z">
                            </path>
                        </svg>
                        <input id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password"
                            placeholder="Confirm new password"
                            class="block w-full pl-11 pr-12 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition duration-150 ease-in-out">
                        <button type="button" 
                            id="confirm-password-toggle"
                            class="absolute inset-y-0 right-0 my-1 mr-1 inline-flex items-center justify-center w-10 rounded-md text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <svg id="confirm-password-eye" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg id="confirm-password-eye-slash" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('Reset Password') }}
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

    <script>
        // Password visibility toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.getElementById('password-toggle');
            const passwordEye = document.getElementById('password-eye');
            const passwordEyeSlash = document.getElementById('password-eye-slash');

            const confirmPasswordInput = document.getElementById('password_confirmation');
            const confirmPasswordToggle = document.getElementById('confirm-password-toggle');
            const confirmPasswordEye = document.getElementById('confirm-password-eye');
            const confirmPasswordEyeSlash = document.getElementById('confirm-password-eye-slash');

            // Password toggle
            if (passwordToggle && passwordInput) {
                passwordToggle.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    // Toggle eye icons
                    if (type === 'text') {
                        passwordEye.classList.add('hidden');
                        passwordEyeSlash.classList.remove('hidden');
                    } else {
                        passwordEye.classList.remove('hidden');
                        passwordEyeSlash.classList.add('hidden');
                    }
                });
            }

            // Confirm password toggle
            if (confirmPasswordToggle && confirmPasswordInput) {
                confirmPasswordToggle.addEventListener('click', function() {
                    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    confirmPasswordInput.setAttribute('type', type);
                    
                    // Toggle eye icons
                    if (type === 'text') {
                        confirmPasswordEye.classList.add('hidden');
                        confirmPasswordEyeSlash.classList.remove('hidden');
                    } else {
                        confirmPasswordEye.classList.remove('hidden');
                        confirmPasswordEyeSlash.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>
