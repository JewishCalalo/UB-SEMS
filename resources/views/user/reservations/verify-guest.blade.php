<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SEMS - Verify Reservation</title>
    <link rel="icon" type="image/png" href="{{ asset('images/ub-logo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/ub-logo.png') }}">
    @vite([
        'resources/js/app.js',
        'resources/css/app.css',
        'resources/css/components/buttons.css',
        'resources/css/modules/auth.css',
        'resources/css/modules/welcome.css'
    ])
</head>
<body class="font-sans antialiased min-h-screen" style="background-image: url('{{ asset('images/Background.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; min-height: 100vh;">
    <x-welcome-navigation/>

    <div class="min-h-screen flex flex-col px-4 sm:px-6 lg:px-8 py-6 sm:py-0 relative">
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        <div class="flex-1 flex items-center justify-center relative z-10">
        <div class="w-full max-w-sm px-4 sm:px-6 py-6 sm:py-8 bg-white shadow-md rounded-lg border border-gray-100">
            <div class="mb-4 text-center">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900">Verify Your Email</h2>
                <p class="text-sm sm:text-base text-gray-600 mt-1">We sent a 6‑digit code to <strong>{{ $email }}</strong>.</p>
            </div>

            <div id="resendInlineMsg" class="hidden mb-4 text-sm rounded border px-3 py-2"></div>

            @if($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-red-800 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('reservations.verify-guest.submit') }}" class="space-y-5" id="verifyGuestForm">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="flex items-center justify-center gap-2">
                    <input type="text" inputmode="numeric" maxlength="1" class="w-12 h-12 text-center border rounded focus:ring-2 focus:ring-red-500" oninput="otpShift(this,1)">
                    <input type="text" inputmode="numeric" maxlength="1" class="w-12 h-12 text-center border rounded focus:ring-2 focus:ring-red-500" oninput="otpShift(this,2)">
                    <input type="text" inputmode="numeric" maxlength="1" class="w-12 h-12 text-center border rounded focus:ring-2 focus:ring-red-500" oninput="otpShift(this,3)">
                    <input type="text" inputmode="numeric" maxlength="1" class="w-12 h-12 text-center border rounded focus:ring-2 focus:ring-red-500" oninput="otpShift(this,4)">
                    <input type="text" inputmode="numeric" maxlength="1" class="w-12 h-12 text-center border rounded focus:ring-2 focus:ring-red-500" oninput="otpShift(this,5)">
                    <input type="text" inputmode="numeric" maxlength="1" class="w-12 h-12 text-center border rounded focus:ring-2 focus:ring-red-500" oninput="otpShift(this,6)">
                </div>
                <input type="hidden" name="code" id="otp_code">
                <button type="submit" 
                        style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); color: white; padding: 12px 18px; border-radius: 10px; border: none; font-weight: 600; font-size: 15px; width: 100%; transition: all 0.3s; cursor: pointer; box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3); display: inline-flex; align-items: center; justify-content: center; gap: 8px; transform: translateY(0);"
                        onmouseover="this.style.background='linear-gradient(135deg, #b91c1c 0%, #991b1b 100%)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 20px rgba(220, 38, 38, 0.4)'"
                        onmouseout="this.style.background='linear-gradient(135deg, #dc2626 0%, #b91c1c 100%)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(220, 38, 38, 0.3)'">
                    Verify
                </button>
                <button type="button" id="resendBtn"
                        class="w-full mt-2 px-4 py-2 rounded-lg border border-orange-500 text-orange-600 hover:bg-orange-50 transition-colors"
                        onclick="resendGuestCode()">
                    Resend Code
                </button>
        </form>
        </div>
        </div>
    <!-- Footer -->
    <x-site-footer/>
    </div>

    <script>
        function otpShift(el, idx) {
            const val = el.value.replace(/\D/g,'');
            el.value = val.substring(0,1);
            const inputs = Array.from(document.querySelectorAll('input[inputmode="numeric"]'));
            const code = inputs.map(i => i.value || '').join('');
            document.getElementById('otp_code').value = code;
            if (val && idx < inputs.length) {
                inputs[idx].focus();
            }
        }

        function showInlineMsg(text, type) {
            const box = document.getElementById('resendInlineMsg');
            if (!box) return;
            box.classList.remove('hidden');
            box.textContent = text;
            // reset classes
            box.classList.remove('bg-green-50','border-green-200','text-green-800');
            box.classList.remove('bg-orange-50','border-orange-200','text-orange-800');
            box.classList.remove('bg-red-50','border-red-200','text-red-800');
            if (type === 'success') {
                box.classList.add('bg-green-50','border-green-200','text-green-800');
            } else if (type === 'warn') {
                box.classList.add('bg-orange-50','border-orange-200','text-orange-800');
            } else {
                box.classList.add('bg-red-50','border-red-200','text-red-800');
            }
        }

        function resendGuestCode() {
            const btn = document.getElementById('resendBtn');
            const form = document.getElementById('verifyGuestForm');
            if (!form || !btn) return;
            const token = form.querySelector('input[name="token"]').value;
            btn.disabled = true;
            const original = btn.textContent;
            btn.textContent = 'Sending...';
            fetch('{{ route('reservations.verify-guest.resend') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ token })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showInlineMsg('A new code has been sent to your email.', 'success');
                } else {
                    // 429 throttle message comes through here too
                    showInlineMsg(data.message || 'Failed to resend code.', data.message && data.message.toLowerCase().includes('wait') ? 'warn' : 'error');
                }
            })
            .catch(() => showInlineMsg('Failed to resend code.', 'error'))
            .finally(() => { btn.disabled = false; btn.textContent = original; });
        }
    </script>
</body>
</html>


