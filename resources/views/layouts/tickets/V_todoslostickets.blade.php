<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tickets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(session('success'))
                        <div class="bg-green-500 text-white p-3 rounded-md mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($noTickets)
                        <p>{{ __('No hay tickets') }}</p>
                    @else
                        <table class="min-w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('ID') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Local_id') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Evento_id') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Plan_id') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Tipo') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Número Asiento') }}</th>
                                    <th class="px-6 py-3 border-b border-gray-200 dark:border-gray-600" scope="col">{{ __('Estado') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $ticket)
                                    <tr>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $ticket->id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $ticket->local_id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $ticket->evento_id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $ticket->plan_id }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $ticket->tipo }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $ticket->numero_asiento }}</td>
                                        <td class="px-6 py-4 border-b border-gray-200 dark:border-gray-600">{{ $ticket->estado }}</td>
                                    å</tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>