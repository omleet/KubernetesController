<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('Your Devices') }}
            </h2>
            <a href="{{ route('Devices.create') }}" class="flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                </svg>
                <span>Add Device</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            @if ($devices == null)
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-700 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 dark:text-white">No Devices Found</h4>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">
                        Get started by adding your first device
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('Devices.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 border border-transparent rounded-md font-medium text-white shadow-sm hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                            Add Device
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="grid grid-cols-1 gap-6">
                @foreach ($devices as $device)
                <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700 transition-all hover:shadow-xl">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-gray-800 dark:text-white">{{ $device['name'] }}'s Details</h4>
                                <div class="flex items-center mt-1">
                                    @if ($device['online'])
                                    <span class="flex w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                                    <span class="text-sm text-green-600 dark:text-green-400 font-medium">Online</span>
                                    @else
                                    <span class="flex w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                    <span class="text-sm text-red-600 dark:text-red-400 font-medium">Unreachable</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                @if ($device['online'])
                                <a href="{{ route('Devices.edit', $device['id']) }}" class="p-2 text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                                @else
                                <a href="{{ route('Devices.edit', $device['id']) }}" class="p-2 text-gray-500 hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Connection
                                    </p>
                                    <p class="mt-1 text-gray-800 dark:text-gray-200 font-mono">
                                        {{ $device['method'] }}://{{ $device['endpoint'] }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Username
                                    </p>
                                    <p class="mt-1 text-gray-800 dark:text-gray-200">
                                        {{ $device['username'] }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Timeout
                                    </p>
                                    <p class="mt-1 text-gray-800 dark:text-gray-200">
                                        {{ $device['timeout'] }} seconds
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Last Activity
                                    </p>
                                    <p class="mt-1 text-gray-800 dark:text-gray-200">
                                        {{-- You might want to add last activity timestamp here --}}
                                        Recently
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex flex-col justify-between">
                                @if ($device['online'])
                                <div class="space-y-3">
                                    <a class="block w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg shadow text-center font-medium text-white hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all use-device-btn"
                                        href="{{ route('Devices.index', $device['id']) }}"
                                        data-device-id="{{ $device['id'] }}"
                                        data-device-name="{{ $device['name'] }}"
                                        onclick="event.preventDefault(); 
                                        fetch('{{ route('set-device-session', $device['id']) }}')
                                            .then(() => window.location.href = this.getAttribute('href'));">
                                        Connect
                                    </a>
                                    <a class="block w-full px-4 py-3 bg-gradient-to-r from-yellow-500 to-amber-500 rounded-lg shadow text-center font-medium text-white hover:from-yellow-600 hover:to-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all"
                                        href="{{ route('Devices.edit', $device['id']) }}">
                                        Configure
                                    </a>
                                </div>
                                @else
                                <div>
                                    <a class="block w-full px-4 py-3 bg-gradient-to-r from-gray-200 to-gray-300 rounded-lg shadow text-center font-medium text-gray-800 hover:from-gray-300 hover:to-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all"
                                        href="{{ route('Devices.edit', $device['id']) }}">
                                        Edit Configuration
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</x-app-layout>