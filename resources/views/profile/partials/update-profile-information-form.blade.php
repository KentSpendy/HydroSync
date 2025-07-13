<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>
        <p class="mt-1 text-sm text-gray-600">
            Update your account's profile information and email address.
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Name" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" 
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" 
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Profile Photo -->
        <div>
            <x-input-label for="profile_photo" value="Profile Photo" />
            <div class="flex items-center space-x-4 mt-2">
                @if ($user->profile_photo)
                    <img src="{{ asset('storage/avatars/' . $user->profile_photo) }}" alt="Profile Photo" 
                         class="w-16 h-16 rounded-full object-cover border">
                @else
                    <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <input type="file" name="profile_photo" class="text-sm text-gray-700" accept="image/*" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Save</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition 
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-green-600">Saved.</p>
            @endif
        </div>
    </form>
</section>
