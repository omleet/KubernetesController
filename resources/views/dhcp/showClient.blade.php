<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col space-y-1">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                DHCP Client "{{$client['interface']}}" Information
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Detailed information about the DHCP Client "{{$client['interface']}}"
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
            <!-- DHCP Client Details Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 
                        rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <!-- Header section with icon and title -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <!-- Ícone representando o client (pode ser ajustado conforme necessidade) -->
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12h6m2 0a2 2 0 100-4 2 2 0 000 4zm0 0v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m0 0a2 2 0 012-2h6a2 2 0 012 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Client Details</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Configuration and settings for this DHCP client
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Main content divided in two sections: Client Attributes and JSON Data -->
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                        <!-- Client Information Section -->
                        <div class="space-y-6">
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Basic Information</h4>
                                <dl class="space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Interface</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                            {{ $client['interface'] ?? '-' }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Add Default Route</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                            {{ $client['add-default-route'] ?? '-' }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Use Peer DNS</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                            {{ $client['use-peer-dns'] ?? '-' }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Use Peer NTP</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                            {{ $client['use-peer-ntp'] ?? '-' }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- JSON Data Section -->
                        <div>
                            <div class="p-6 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700 h-full">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Raw Data</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400">
                                        JSON Format
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    Complete DHCP client data in JSON format for debugging and reference.
                                </p>
                                <div class="p-4 overflow-auto text-sm bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <pre class="text-gray-800 dark:text-gray-300 font-mono text-xs">{{ $json }}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Back to List Button -->
                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('dhcp_client', $deviceParam) }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
