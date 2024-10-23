<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Profile Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-secondary-button class="mt-2 me-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <div id="name" class="mt-1 block w-full bg-gray-100 p-2 rounded text-gray-700">
                {{ $state['name'] }}
            </div>
        </div>

        <div class="col-span-6 sm:col-span-4">
            @if (Auth::user()->role === 'alumni') <!-- Check if the user has the alumni role -->
            <!-- Contact Info -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="contact_info" value="{{ __('Contact Info') }}" />
                <x-input id="contact_info" type="text" class="mt-1 block w-full" wire:model.defer="state.contact_info" autocomplete="contact-info" />
                <x-input-error for="contact_info" class="mt-2" />
            </div>

            <!-- Jobs -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="jobs" value="{{ __('Jobs') }}" />
                <x-input id="jobs" type="text" class="mt-1 block w-full" wire:model.defer="state.jobs" autocomplete="jobs" />
                <x-input-error for="jobs" class="mt-2" />
            </div>

            <!-- Achievements -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="achievements" value="{{ __('Achievements') }}" />
            
                <!-- Input field for adding new achievements -->
                <input type="text" id="newAchievement" class="block w-full mt-1" placeholder="Enter an achievement" />
            
                <button type="button" id="addAchievementBtn" class="mt-2 bg-blue-500 text-white px-4 py-1 rounded">
                    Add Achievement
                </button>
            
                <!-- Display list of added achievements -->
                <ul id="achievementsList" class="mt-3">
                    <!-- Achievements will be dynamically inserted here -->
                </ul>
            
                <!-- Hidden input to store achievements as a comma-separated string -->
                <textarea name="achievements" id="achievements" class="hidden" wire:model.defer="state.achievements"></textarea>
                <x-input-error for="achievements" class="mt-2" />
            </div>
            
            
            <!-- Bio -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="bio" value="{{ __('Bio') }}" />
                <textarea id="bio" rows="3" class="mt-1 block w-full rounded-md" wire:model.defer="state.bio" autocomplete="bio"></textarea>
                <x-input-error for="bio" class="mt-2" />
            </div>
            
        @endif
        </div>
        

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="mt-1 block w-full" wire:model="state.email" required autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Your email address is unverified.') }}

                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:click.prevent="sendEmailVerification">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let achievements = [];
        
        const addAchievementBtn = document.getElementById('addAchievementBtn');
        const newAchievementInput = document.getElementById('newAchievement');
        const achievementsList = document.getElementById('achievementsList');
        const achievementsInput = document.getElementById('achievements');

        // Add an achievement to the list
        addAchievementBtn.addEventListener('click', function() {
            const newAchievement = newAchievementInput.value.trim();
            
            if (newAchievement) {
                achievements.push(newAchievement);
                updateAchievementsList();
                newAchievementInput.value = ''; // Clear the input
                achievementsInput.value = achievements.join(','); // Update hidden textarea
            }
        });

        // Update the displayed achievements list
        function updateAchievementsList() {
            achievementsList.innerHTML = '';
            achievements.forEach((achievement, index) => {
                const listItem = document.createElement('li');
                listItem.classList.add('bg-blue-100', 'p-2', 'my-1', 'rounded', 'flex', 'justify-between');
                
                listItem.innerHTML = `
                    ${achievement}
                    <button type="button" class="remove-btn" data-index="${index}">x</button>
                `;

                achievementsList.appendChild(listItem);
            });

            // Add event listeners to remove buttons
            document.querySelectorAll('.remove-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const index = this.getAttribute('data-index');
                    achievements.splice(index, 1);
                    updateAchievementsList();
                    achievementsInput.value = achievements.join(','); // Update hidden textarea
                });
            });
        }
    });
</script>

