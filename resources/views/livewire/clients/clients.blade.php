<div>
    <div class="col-md-8 mb-2">
        @if(session()->has('success'))
        {{ session()->get('success') }}
        @endif
        @if(session()->has('error'))
        {{ session()->get('error') }}
        @endif
        @if($addClient)
        @include('livewire.clients.create')
        @endif
        @if($updateClient)
        @include('livewire.clients.update')
        @endif
    </div>
    <div class="col-md-8">
        <div class="p-4">
            <div class="flex justify-end mb-2">
                @if(!$addClient)
                <x-jet-button wire:click="addClient()" class="">
                    Add New client
                </x-jet-button>
                @endif
            </div>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Client
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Phone
                            </th>
                            <th scope="col" class="px-6 py-3">
                                due date
                            </th>
                            <th scope="col" class="px-6 py-3">
                                plan
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($clients) > 0)
                        @foreach ($clients as $client)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$client->full_names}}
                                <br>
                                <span class="text-xs">{{$client->email}}</span>
                            </th>
                            <td class="px-6 py-4">
                                {{$client->phone}}
                            </td>

                            <td class="px-6 py-4">
                                {{date("d F Y",strtotime('+1 month',strtotime($client->plan_start_at)))}}
                            </td>
                            <td class="px-6 py-4">
                                {{$client->plan}}
                            </td>
                            <td class="px-6 py-4">
                                {{$client->status}}
                            </td>
                            <td class="px-6 py-4">
                                <x-jet-secondary-button wire:click="editClient({{$client->id}})">Edit</x-jet-secondary-button>
                                <x-jet-danger-button wire:click="deleteClient({{$client->id}})">Delete</x-jet-danger-button>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td class="px-6 py-4" colspan="6" align="center">
                                No clients Found.
                            </td>
                        </tr>
                        @endif

                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>