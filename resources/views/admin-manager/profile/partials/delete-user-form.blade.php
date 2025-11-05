<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            style="background: linear-gradient(to right, #dc2626, #b91c1c); color: white; padding: 12px 24px; border-radius: 8px; border: none; font-weight: 600; transition: all 0.2s; cursor: pointer; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); display: inline-flex; align-items: center;"
            onmouseover="this.style.background='linear-gradient(to right, #b91c1c, #991b1b)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 12px rgba(0, 0, 0, 0.15)'"
            onmouseout="this.style.background='linear-gradient(to right, #dc2626, #b91c1c)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'">
        <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
        </svg>
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" x-on:click="$dispatch('close')"
                        style="background: linear-gradient(to right, #6b7280, #4b5563); color: white; padding: 10px 20px; border-radius: 8px; border: none; font-weight: 500; transition: all 0.2s; cursor: pointer; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);"
                        onmouseover="this.style.background='linear-gradient(to right, #4b5563, #374151)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.15)'"
                        onmouseout="this.style.background='linear-gradient(to right, #6b7280, #4b5563)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                    {{ __('Cancel') }}
                </button>

                <button type="submit"
                        style="background: linear-gradient(to right, #dc2626, #b91c1c); color: white; padding: 10px 20px; border-radius: 8px; border: none; font-weight: 600; transition: all 0.2s; cursor: pointer; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); display: inline-flex; align-items: center;"
                        onmouseover="this.style.background='linear-gradient(to right, #b91c1c, #991b1b)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.15)'"
                        onmouseout="this.style.background='linear-gradient(to right, #dc2626, #b91c1c)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)'">
                    <svg style="width: 16px; height: 16px; margin-right: 6px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
