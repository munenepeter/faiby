<x-jet-dialog-modal wire:model="updateClient">
    <x-slot name="title">
        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-orange-500 dark:text-white">
                Update Client
            </h3>
            <button wire:click="$toggle('updateClient')" type="button" class="text-orange-500 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="defaultModal">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
        @endif

    </x-slot>

    <x-slot name="content">
        <form>
            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                <div>
                    <x-jet-label for="name" value="{{ __('Full Names') }}" />
                    <x-jet-input id="name" wire:model="name" placeholder="Enter the name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                </div>
                <div>
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" wire:model="email" placeholder="Enter the email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                </div>

            </div>
            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                <div>
                    <x-jet-label for="phone" value="{{ __('Phone Number') }}" />
                    <x-jet-input id="phone" wire:model="phone" placeholder="7XX XXX XXX" class="block mt-1 w-full" type="tel" pattern="[0-9]{9}" name="name" :value="old('phone')" required autofocus />
                </div>
                <div>
                    <x-jet-label for="plan" value="{{ __('Plan') }}" />
                    <select id="plan" wire:model="plan" :value="old('plan')" required autofocus class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected>Choose a plan</option>
                        @if (count($plans) > 0)
                        @foreach ($plans as $plan)
                        <option value="{{ $plan->id }}"> {{ $plan->name }}</option>
                        @endforeach
                        @else
                        <option selected>No plans are available!</option>
                        @endif
                    </select>
                </div>

            </div>
            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                <div>
                    <x-jet-label for="plan_start_at" value="{{ __('Subscription Start') }}" />
                    <x-jet-input id="plan_start_at" wire:model="plan_start_at" placeholder="Enter the phone number" class="block mt-1 w-full" type="date" name="plan_start_at" :value="old('plan_start_at')" required autofocus />
                </div>


            </div>
            <div class="w-full">
                <div>
                    <x-jet-label for="notes" value="{{ __('Client Notes') }}" />
                    <textarea name="notes" id="notes" wire:model="notes" cols="5" rows="5" required autofocus class="bg-gray-50 border border-green-300 text-gray-900 text-sm focus:ring-orange-600 focus:border-orange-600 block w-full p-2.5 rounded-md shadow-sm"></textarea>
                </div>
            </div>
        </form>


    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('updateClient')" wire:loading.attr="disabled">
            Cancel
        </x-jet-secondary-button>

        <x-jet-button class="ml-2" wire:click="storeClient" wire:loading.attr="disabled">
            Save
        </x-jet-button>
    </x-slot>
</x-jet-dialog-modal>