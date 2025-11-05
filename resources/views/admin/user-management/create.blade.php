<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumbs :items="[
                ['label' => 'Dashboard', 'url' => route('dashboard')],
                ['label' => 'User Management', 'url' => route('profile-user-management.index')],
                ['label' => 'Create User']
            ]" />
            <!-- Detail Section -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                <div class="flex flex-col items-center text-center gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Create New Account</h3>
                        <p class="text-base font-medium text-gray-700">Enter the user's University of Baguio email. Password is optional; if left blank, it will default to "1". Instructors will be assigned to the PE Office.</p>
                    </div>
                    <a href="{{ route('profile-user-management.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-semibold">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to User Management
                    </a>
                </div>
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

            <!-- Create Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">User Information</h3>
                    
                    <form method="POST" action="{{ route('profile-user-management.store') }}" class="space-y-6" id="createUserForm">
                        @csrf
                        
                        <div class="grid grid-cols-1 gap-6 max-w-md mx-auto">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                <input type="text" name="email" id="email"
                                       value="{{ old('email') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                       placeholder="Enter Ubaguio email address">
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                                <select name="role" id="role"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                    <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role }}" {{ (old('role', $defaultRole ?? 'instructor') == $role) ? 'selected' : '' }}>
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

                            <!-- Password (optional; default 1 if empty) -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password (optional)</label>
                                <input type="password" name="password" id="password"
                                       class="w-full px-3 py-2 pr-4 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                       placeholder="Leave blank to set default password: 1">
                                @error('password')
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
                        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                            <a href="{{ route('profile-user-management.index') }}" 
                               class="inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 px-6 py-3 text-sm bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" id="createUserBtn"
                                    class="inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 px-6 py-3 text-sm bg-red-600 text-white hover:bg-red-700 focus:ring-red-500">
                                Create User
                            </button>
                        </div>
                    </form>
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
                            <h2 class="text-xl font-bold text-center">User Created!</h2>
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
                            <button type="button" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors transform hover:scale-105" style="border: none !important; outline: none !important;" onclick="Swal.close(); clearForm();">
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
