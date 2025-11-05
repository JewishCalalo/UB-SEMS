<section>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="first_name" :value="__('First name *')" />
                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" autocomplete="given-name" />
                <div id="first_name_error" class="mt-2 text-sm text-red-600 hidden"></div>
                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>
            <div>
                <x-input-label for="last_name" :value="__('Last name *')" />
                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" autocomplete="family-name" />
                <div id="last_name_error" class="mt-2 text-sm text-red-600 hidden"></div>
                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>

        </div>

        <div>
            <x-input-label for="name" :value="__('Display name *')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" autofocus autocomplete="name" />
            <div id="name_error" class="mt-2 text-sm text-red-600 hidden"></div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email *')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" autocomplete="username" />
            <div id="email_error" class="mt-2 text-sm text-red-600 hidden"></div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-2">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-yellow-800">
                                {{ __('Your email address is unverified.') }}
                            </p>
                            <p class="text-sm text-yellow-700 mt-1">
                                {{ __('Please check your email and click the verification link to activate your account.') }}
                            </p>
                            <button form="send-verification" class="mt-2 text-sm text-yellow-600 hover:text-yellow-800 underline font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 rounded">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="contact_number" :value="__('Contact Number *')" />
            <x-text-input id="contact_number" name="contact_number" type="tel" class="mt-1 block w-full" :value="old('contact_number', $user->contact_number)" autocomplete="tel" maxlength="11" placeholder="09XXXXXXXXX" />
            <div class="mt-1 text-xs text-gray-500">Must be 11 digits starting with 09.</div>
            <div id="contact_number_error" class="mt-2 text-sm text-red-600 hidden"></div>
            <x-input-error class="mt-2" :messages="$errors->get('contact_number')" />
        </div>

        @if(!$user->first_name || !$user->last_name || !$user->contact_number)
        <!-- Password fields for first-time login -->
        <div>
            <x-input-label for="password" :value="__('New Password *')" />
            <div class="flex items-center space-x-2">
                <x-text-input id="password" name="password" type="password" class="mt-1 block flex-1" autocomplete="new-password" />
                <button type="button" onclick="togglePasswordVisibility('password')" class="mt-1 p-2 text-gray-400 hover:text-gray-600 focus:outline-none border border-gray-300 rounded-md bg-white">
                    <svg id="password-eye" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
            <div id="password_policy_hint" class="mt-2 text-sm text-gray-500">At least 8 characters with at least 1 special character.</div>
            <div id="password_error" class="mt-2 text-sm text-red-600 hidden"></div>
            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm New Password *')" />
            <div class="flex items-center space-x-2">
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block flex-1" autocomplete="new-password" />
                <button type="button" onclick="togglePasswordVisibility('password_confirmation')" class="mt-1 p-2 text-gray-400 hover:text-gray-600 focus:outline-none border border-gray-300 rounded-md bg-white">
                    <svg id="password_confirmation-eye" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
            <div id="password_match_hint" class="mt-2 text-sm"></div>
            <div id="password_confirmation_error" class="mt-2 text-sm text-red-600 hidden"></div>
            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
        </div>
        @endif

        <div class="flex justify-center items-center gap-4">
            <button type="submit" class="inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 px-6 py-3 text-sm bg-red-600 text-white hover:bg-red-700 focus:ring-red-500">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 4000)"
                    class="text-sm text-green-600 font-medium flex items-center"
                >
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ __('Profile updated successfully!') }}
                </p>
            @endif

        </div>
    </form>

    <script>
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(fieldId + '-eye');
            
            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                `;
            } else {
                field.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }

        // Form validation for first-time login
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action="{{ route('profile.update') }}"]');
            const first_name = document.getElementById('first_name');
            const last_name = document.getElementById('last_name');
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const contact_number = document.getElementById('contact_number');
            const password = document.getElementById('password');
            const password_confirmation = document.getElementById('password_confirmation');

            // Validation functions
            function validateField(field, errorId, message) {
                const errorDiv = document.getElementById(errorId);
                if (!field.value.trim()) {
                    errorDiv.textContent = message;
                    errorDiv.classList.remove('hidden');
                    field.classList.add('border-red-500');
                    return false;
                } else {
                    errorDiv.classList.add('hidden');
                    field.classList.remove('border-red-500');
                    return true;
                }
            }

            function validateEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            function validatePassword(password) {
                return password.length >= 8 && /[^A-Za-z0-9]/.test(password);
            }

            // Live validation for password policy
            if (password) {
                password.addEventListener('input', function() {
                    const hint = document.getElementById('password_policy_hint');
                    const value = this.value;
                    const lengthOk = value.length >= 8;
                    const specialOk = /[^A-Za-z0-9]/.test(value);
                    
                    hint.classList.remove('text-red-600', 'text-green-600');
                    hint.classList.add(lengthOk && specialOk ? 'text-green-600' : 'text-red-600');
                    hint.textContent = lengthOk && specialOk ? 'Password meets the policy.' : 'At least 8 characters with at least 1 special character.';
                });
            }

            // Live validation for password match
            if (password_confirmation) {
                password_confirmation.addEventListener('input', function() {
                    const matchHint = document.getElementById('password_match_hint');
                    const ok = password.value === this.value;
                    
                    matchHint.classList.remove('text-red-600', 'text-green-600');
                    if (this.value.length === 0) { 
                        matchHint.textContent = ''; 
                        return; 
                    }
                    matchHint.classList.add(ok ? 'text-green-600' : 'text-red-600');
                    matchHint.textContent = ok ? 'Passwords match.' : 'Passwords do not match.';
                });
            }

            // Additional live validation for PH contact number
            function validatePhContact(value){
                return /^09\d{9}$/.test(value.trim());
            }
            if (contact_number){
                contact_number.addEventListener('input', function(){
                    if (this.value.length > 11) this.value = this.value.slice(0,11);
                });
            }

            // Form submission validation
            if (form) {
                form.addEventListener('submit', function(e) {
                    let isValid = true;

                    // Validate required fields
                    if (!validateField(first_name, 'first_name_error', 'First name is required.')) isValid = false;
                    if (!validateField(last_name, 'last_name_error', 'Last name is required.')) isValid = false;
                    if (!validateField(name, 'name_error', 'Display name is required.')) isValid = false;
                    if (!validateField(contact_number, 'contact_number_error', 'Contact number is required.')) isValid = false;
                    else if (!validatePhContact(contact_number.value)){
                        const err = document.getElementById('contact_number_error');
                        err.textContent = 'Contact number must be 11 digits and start with 09.';
                        err.classList.remove('hidden');
                        contact_number.classList.add('border-red-500');
                        isValid = false;
                    } else {
                        document.getElementById('contact_number_error').classList.add('hidden');
                        contact_number.classList.remove('border-red-500');
                    }

                    // Validate email format
                    if (!email.value.trim()) {
                        document.getElementById('email_error').textContent = 'Email is required.';
                        document.getElementById('email_error').classList.remove('hidden');
                        email.classList.add('border-red-500');
                        isValid = false;
                    } else if (!validateEmail(email.value)) {
                        document.getElementById('email_error').textContent = 'Please enter a valid email address.';
                        document.getElementById('email_error').classList.remove('hidden');
                        email.classList.add('border-red-500');
                        isValid = false;
                    } else {
                        document.getElementById('email_error').classList.add('hidden');
                        email.classList.remove('border-red-500');
                    }

                    // Validate password for first-time login
                    if (password) {
                        if (!password.value.trim()) {
                            document.getElementById('password_error').textContent = 'Password is required.';
                            document.getElementById('password_error').classList.remove('hidden');
                            password.classList.add('border-red-500');
                            isValid = false;
                        } else if (!validatePassword(password.value)) {
                            document.getElementById('password_error').textContent = 'Password must be at least 8 characters with at least 1 special character.';
                            document.getElementById('password_error').classList.remove('hidden');
                            password.classList.add('border-red-500');
                            isValid = false;
                        } else {
                            document.getElementById('password_error').classList.add('hidden');
                            password.classList.remove('border-red-500');
                        }

                        if (!password_confirmation.value.trim()) {
                            document.getElementById('password_confirmation_error').textContent = 'Password confirmation is required.';
                            document.getElementById('password_confirmation_error').classList.remove('hidden');
                            password_confirmation.classList.add('border-red-500');
                            isValid = false;
                        } else if (password.value !== password_confirmation.value) {
                            document.getElementById('password_confirmation_error').textContent = 'Passwords do not match.';
                            document.getElementById('password_confirmation_error').classList.remove('hidden');
                            password_confirmation.classList.add('border-red-500');
                            isValid = false;
                        } else {
                            document.getElementById('password_confirmation_error').classList.add('hidden');
                            password_confirmation.classList.remove('border-red-500');
                        }
                    }

                    if (!isValid) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
</section>
