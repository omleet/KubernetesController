<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col space-y-1">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Static Route "{{ $route['dst-address'] }}"
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Detailed information about the static route "{{ $route['dst-address'] }}"
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
            <!-- Static Route Details Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Route Details</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Configuration and settings for this static route</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                        <!-- Route Attributes -->
                        <div class="space-y-6">
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Basic Information</h4>
                                <dl class="space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Destination Address</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{ isset($route['dst-address']) ? $route['dst-address'] : '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Gateway</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ isset($route['gateway']) ? $route['gateway'] : '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Check Gateway</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ isset($route['check-gateway']) ? $route['check-gateway'] : '-' }}</dd>
                                    </div>
                                </dl>
                            </div>
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Advanced Settings</h4>
                                <dl class="space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Suppress Hardware Offload</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ isset($route['suppress-hw-offload']) ? $route['suppress-hw-offload'] : '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Distance</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ isset($route['distance']) ? $route['distance'] : '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Scope</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ isset($route['scope']) ? $route['scope'] : '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Target Scope</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ isset($route['target-scope']) ? $route['target-scope'] : '-' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        <!-- JSON Data -->
                        <div>
                            <div class="p-6 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700 h-full">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Raw Data</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400">
                                        JSON Format
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    Complete static route data in JSON format for debugging and reference.
                                </p>
                                <div class="p-4 overflow-auto text-sm bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <pre class="text-gray-800 dark:text-gray-300 font-mono text-xs">{{ $json }}</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('StaticRoutes.index', $deviceParam) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>