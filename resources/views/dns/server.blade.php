<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col space-y-1">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                DNS Configuration
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Current DNS server settings and statistics
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
            <!-- DNS Info Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">DNS Server Information</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Current configuration and performance metrics</p>
                            </div>
                        </div>
                    </div>

                    @if ($server != "-1")
                        <div class="space-y-8">
                            <!-- DNS Servers Section -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- DNS Servers -->
                                <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">DNS Servers</h4>
                                    <dl class="space-y-4">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Primary Servers</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $server['servers'] != "" ? $server['servers'] : 'Not configured' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dynamic Servers</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ $server['dynamic-servers'] != "" ? $server['dynamic-servers'] : 'Not configured' }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- DoH Configuration -->
                                <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">DNS over HTTPS</h4>
                                    <dl class="space-y-4">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">DoH Server</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                                @if ($server['use-doh-server'] != "")
                                                    {{ $server['use-doh-server'] }} 
                                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $server['verify-doh-cert'] == "false" ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' }}">
                                                        {{ $server['verify-doh-cert'] == "false" ? "Unverified" : "Verified" }}
                                                    </span>
                                                @else
                                                    Disabled
                                                @endif
                                            </dd>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Max Queries</dt>
                                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $server['doh-max-concurrent-queries'] }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Max Connections</dt>
                                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $server['doh-max-server-connections'] }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Timeout</dt>
                                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $server['doh-timeout'] }}</dd>
                                            </div>
                                        </div>
                                    </dl>
                                </div>
                            </div>

                            <!-- General Configuration -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Server Settings -->
                                <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Server Configuration</h4>
                                    <dl class="grid grid-cols-2 gap-4">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Remote Requests</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $server['allow-remote-requests'] == "true" ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                                    {{ $server['allow-remote-requests'] == "true" ? "Allowed" : "Blocked" }}
                                                </span>
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">VRF</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $server['vrf'] ?: 'Default' }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Max Queries</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $server['max-concurrent-queries'] }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">TCP Sessions</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $server['max-concurrent-tcp-sessions'] }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">UDP Packet Size</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $server['max-udp-packet-size'] }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Extra Time</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $server['address-list-extra-time'] }}</dd>
                                        </div>
                                    </dl>
                                </div>

                                <!-- Cache Settings -->
                                <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Cache Settings</h4>
                                    <dl class="grid grid-cols-2 gap-4">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cache Size</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $server['cache-size'] }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cache Used</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $server['cache-used'] }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Max TTL</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $server['cache-max-ttl'] }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Server Timeout</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $server['query-server-timeout'] }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Timeout</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $server['query-total-timeout'] }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-8 flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-3 justify-end">
                            <a href="{{ route('editDnsServer', $deviceParam) }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-green-500 to-teal-500 hover:from-green-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit DNS Configuration
                            </a>
                            <button onclick="location.reload();" type="button" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Refresh Information
                            </button>
                        </div>
                    @else
                        <div class="p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-100 dark:border-red-900/30">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-400">Connection Error</h3>
                                    <div class="mt-2 text-sm text-red-700 dark:text-red-400">
                                        <p>Failed to load DNS configuration information.</p>
                                        <p class="mt-1 font-mono text-xs">{{ $conn_error }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>