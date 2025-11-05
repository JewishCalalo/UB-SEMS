<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Edit User') }}
                    </h2>
                    <p class="text-sm text-gray-600">Update user information and settings</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'User Management', 'url' => route('profile-user-management.index')],
                ['label' => 'User Details', 'url' => route('profile-user-management.show', $user)],
                ['label' => 'Edit User']
            ]" />

            <!-- Back Button -->
            <div class="mb-6 flex justify-center">
                <a href="{{ url()->previous() }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-semibold">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Previous Page
                </a>
            </div>

            <!-- Error Validation Card -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-red-800 mb-2">Please correct the following errors:</h4>
                            <ul class="text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-center">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></span>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Edit Form Card -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-red-600 px-6 py-4 text-center">
                    <h3 class="text-lg font-semibold text-white flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit User: {{ $user->name }}
                    </h3>
                    <p class="text-red-100 text-sm mt-1">Update user information and password</p>
                </div>
                
                <div class="p-6">
                    <!-- User Information Section -->
                    <div class="mb-8">
                        <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-6">
                            <h4 class="text-md font-semibold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                User Information
                            </h4>
                        </div>
                        
                        <form method="POST" action="{{ route('profile-user-management.update', $user) }}" class="space-y-6" id="updateUserForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 gap-6 max-w-md mx-auto">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                    <input type="text" name="name" id="name"
                                           value="{{ old('name', $user->name) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all"
                                           placeholder="Enter full name">
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                                    <input type="email" name="email" id="email"
                                           value="{{ old('email', $user->email) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all"
                                           placeholder="Enter Ubaguio email address"
                                           onchange="checkEmailChange()">
                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    
                                    <!-- Email Change Warning -->
                                    <div id="email-change-warning" class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg hidden">
                                        <div class="flex items-start">
                                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-yellow-800">Email Change Detected</p>
                                                <p class="text-sm text-yellow-700 mt-1">
                                                    Changing the email will require the user to verify their new email address. 
                                                    A verification email will be sent automatically.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Role -->
                                <div>
                                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Role *</label>
                                    <select name="role" id="role"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all">
                                        @foreach($roles as $role)
                                            <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>
                                                {{ ucfirst($role) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex justify-center space-x-4 pt-6 border-t border-gray-200">
                                <a href="{{ route('profile-user-management.show', $user) }}" 
                                   class="inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 px-6 py-3 text-sm bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500">
                                    <i class="fas fa-times mr-2"></i>
                                    Cancel
                                </a>
                                <button type="submit" id="updateUserBtn" class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Update User
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Password Change Section -->
                    <div class="border-t border-gray-200 pt-8">
                        <div class="bg-red-50 border-l-4 border-red-500 px-4 py-3 mb-8">
                            <h4 class="text-md font-semibold text-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Change Password
                            </h4>
                        </div>
                        
                        <form method="POST" action="{{ route('profile-user-management.password', $user) }}" class="space-y-6" id="updatePasswordForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="max-w-md mx-auto">
                                <div class="mb-6">
                                    <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-3">New Password *</label>
                                    <div class="relative flex items-center">
                                        <div class="relative flex-1">
                                            <input type="password" name="new_password" id="new_password" required
                                                   class="w-full px-4 py-3 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all"
                                                   placeholder="Enter new password">
                                        </div>
                                        <button type="button" 
                                                class="ml-2 p-2 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded-lg hover:bg-gray-100"
                                                onclick="togglePasswordVisibility('new_password', 'new-password-eye', 'new-password-eye-slash')">
                                            <svg id="new-password-eye" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <svg id="new-password-eye-slash" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="mb-8">
                                    <label for="new_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-3">Confirm New Password *</label>
                                    <div class="relative flex items-center">
                                        <div class="relative flex-1">
                                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                                                   class="w-full px-4 py-3 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-sm font-medium transition-all"
                                                   placeholder="Confirm new password">
                                        </div>
                                        <button type="button" 
                                                class="ml-2 p-2 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded-lg hover:bg-gray-100"
                                                onclick="togglePasswordVisibility('new_password_confirmation', 'confirm-new-password-eye', 'confirm-new-password-eye-slash')">
                                            <svg id="confirm-new-password-eye" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            <svg id="confirm-new-password-eye-slash" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="flex justify-center">
                                    <button type="submit" id="updatePasswordBtn" class="inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        Change Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Error Modal -->
    @if(session('error'))
        <div id="errorModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
            <div class="relative mx-auto border w-full max-w-xs shadow-2xl rounded-xl bg-white">
                <div class="space-y-6 p-6">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-red-600 to-red-700 text-white p-4 -m-6 mb-6 rounded-t-xl">
                        <div class="flex items-center justify-center gap-3">
                            <div class="p-2 bg-red-100 rounded-lg">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold">Error!</h2>
                        </div>
                    </div>
                    <!-- Message -->
                    <div class="text-center">
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center justify-center mb-3">
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-lg font-bold text-red-800 mb-2">Operation Failed!</h3>
                            <p class="text-sm font-medium text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                    <!-- Action Button -->
                    <div class="flex justify-center pt-4">
                        <button onclick="closeErrorModal()" 
                                class="px-8 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold shadow-lg">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show success modal if there's a success message
            @if(session('success'))
                Swal.fire({
                    icon: false,
                    html: `
                        <div class="bg-green-500 text-white p-4 rounded-t-lg -m-6 -mt-6 mb-4" style="margin-left: -24px; margin-right: -24px; margin-top: -24px;">
                            <h2 class="text-xl font-bold text-center">User Updated!</h2>
                        </div>
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-gray-700">{{ session('success') }}</p>
                        </div>
                        <div class="flex justify-center mt-6">
                            <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" style="border: none !important; outline: none !important;" onclick="Swal.close();">
                                OK
                            </button>
                        </div>
                    `,
                    showConfirmButton: false,
                    showCancelButton: false,
                    customClass: {
                        popup: 'swal-custom-popup'
                    }
                });
            @endif
        });

        function closeErrorModal() {
            document.getElementById('errorModal').style.display = 'none';
        }


        // Store original email value
        const originalEmail = '{{ $user->email }}';
        
        function checkEmailChange() {
            const emailInput = document.getElementById('email');
            const warningDiv = document.getElementById('email-change-warning');
            
            if (emailInput.value !== originalEmail) {
                warningDiv.classList.remove('hidden');
            } else {
                warningDiv.classList.add('hidden');
            }
        }
        
        function togglePasswordVisibility(inputId, eyeId, eyeSlashId) {
            const input = document.getElementById(inputId);
            const eye = document.getElementById(eyeId);
            const eyeSlash = document.getElementById(eyeSlashId);
            
            if (input && eye && eyeSlash) {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                
                // Toggle eye icons
                if (type === 'text') {
                    eye.classList.add('hidden');
                    eyeSlash.classList.remove('hidden');
                } else {
                    eye.classList.remove('hidden');
                    eyeSlash.classList.add('hidden');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Allow normal form submission for proper validation error display
            // No AJAX handling needed - Laravel will handle validation and redirects
        });
    </script>
</x-app-layout>
