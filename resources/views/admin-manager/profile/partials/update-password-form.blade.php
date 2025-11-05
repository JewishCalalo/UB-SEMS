<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <div class="relative flex items-center">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full pl-11 pr-4" autocomplete="current-password" />
                </div>
                <button type="button" 
                        class="ml-2 mt-1 p-2 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded-md hover:bg-gray-100"
                        onclick="togglePasswordVisibility('update_password_current_password', 'current-password-eye', 'current-password-eye-slash')">
                    <svg id="current-password-eye" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg id="current-password-eye-slash" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <div class="relative flex items-center">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full pl-11 pr-4" autocomplete="new-password" />
                </div>
                <button type="button" 
                        class="ml-2 mt-1 p-2 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded-md hover:bg-gray-100"
                        onclick="togglePasswordVisibility('update_password_password', 'new-password-eye', 'new-password-eye-slash')">
                    <svg id="new-password-eye" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg id="new-password-eye-slash" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                    </svg>
                </button>
            </div>
            <p id="password_policy_hint" class="mt-2 text-sm text-gray-500">At least 8 characters with at least 1 special character.</p>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <div class="relative flex items-center">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full pl-11 pr-4" autocomplete="new-password" />
                </div>
                <button type="button" 
                        class="ml-2 mt-1 p-2 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded-md hover:bg-gray-100"
                        onclick="togglePasswordVisibility('update_password_password_confirmation', 'confirm-password-eye', 'confirm-password-eye-slash')">
                    <svg id="confirm-password-eye" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg id="confirm-password-eye-slash" class="h-5 w-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                    </svg>
                </button>
            </div>
            <p id="password_match_hint" class="mt-2 text-sm"></p>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" style="background: linear-gradient(to right, #10b981, #059669); color: white; padding: 12px 24px; border-radius: 8px; border: none; font-weight: 600; transition: all 0.2s; cursor: pointer; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); display: inline-flex; align-items: center;"
                    onmouseover="this.style.background='linear-gradient(to right, #059669, #047857)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 12px rgba(0, 0, 0, 0.15)'"
                    onmouseout="this.style.background='linear-gradient(to right, #10b981, #059669)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'">
                <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Your password has been updated successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#10b981',
                            customClass: {
                                confirmButton: 'swal2-confirm-button'
                            }
                        });
                    });
                </script>
            @endif
        </div>
    </form>

    <script>
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

        // Live password policy validation
        document.addEventListener('DOMContentLoaded', function() {
            const pwd = document.getElementById('update_password_password');
            const pwd2 = document.getElementById('update_password_password_confirmation');
            const hint = document.getElementById('password_policy_hint');
            const matchHint = document.getElementById('password_match_hint');
            function validatePwd() {
                const value = pwd.value || '';
                const lengthOk = value.length >= 8;
                const specialOk = /[^A-Za-z0-9]/.test(value);
                hint.classList.remove('text-red-600','text-green-600');
                hint.classList.add(lengthOk && specialOk ? 'text-green-600' : 'text-red-600');
                hint.textContent = lengthOk && specialOk ? 'Password meets the policy.' : 'At least 8 characters with at least 1 special character.';
                validateMatch();
            }
            function validateMatch() {
                const ok = (pwd.value || '') === (pwd2.value || '');
                matchHint.classList.remove('text-red-600','text-green-600');
                if (pwd2.value.length === 0) { matchHint.textContent = ''; return; }
                matchHint.classList.add(ok ? 'text-green-600' : 'text-red-600');
                matchHint.textContent = ok ? 'Passwords match.' : 'Passwords do not match.';
            }
            if (pwd && pwd2) {
                pwd.addEventListener('input', validatePwd);
                pwd2.addEventListener('input', validateMatch);
            }
        });
    </script>
</section>
