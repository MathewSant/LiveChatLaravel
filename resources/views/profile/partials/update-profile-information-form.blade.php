<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')
    
        <!-- Exibição e upload da Foto de Perfil -->
        <div class="flex flex-col items-center">
            <div class="relative">
                @php
                $defaultSvg = '<svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400 rounded-full" viewBox="0 0 24 24" fill="#9ca3af">
                    <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4z"/>
                    <path d="M12 14c-4.42 0-8 1.79-8 4v2h16v-2c0-2.21-3.58-4-8-4z"/>
                </svg>';
                $defaultSrc = 'data:image/svg+xml;base64,' . base64_encode($defaultSvg);
            @endphp
            
            @if ($user->profile_image)
                <img id="profilePreview" src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="h-24 w-24 rounded-full object-cover shadow-md">
            @else
                <img id="profilePreview" src="{{ $defaultSrc }}" alt="Default Avatar" class="h-24 w-24 rounded-full  object-cover shadow-md">
            @endif
            
                <!-- Ícone para indicar que é editável -->
                <label for="profile_image" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 opacity-0 hover:opacity-100 transition-opacity rounded-full cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-4.553a1 1 0 00-1.414-1.414L13.586 8.586A2 2 0 0012 9.414a2 2 0 00-1.586-.828L6.86 6.86a1 1 0 00-1.414 1.414L9 11m6 3v6m0 0H9m6 0l3.293-3.293" />
                    </svg>
                </label>
            </div>
            <!-- Input file escondido -->
            <input id="profile_image" name="profile_image" type="file" accept="image/*" class="hidden" onchange="previewImage(event)">
            @error('profile_image')
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>
    
        <!-- Outros campos do formulário -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
    
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
    
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
    
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
<script>
    function previewImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>