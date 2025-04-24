@if ($resource != null)
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        <!-- Left Column -->
        <div class="space-y-6">
            <!-- Board Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Board Information</h3>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $resource['platform'] }} {{ $resource['board-name'] }}</h2>
                    </div>
                </div>
            </div>

            <!-- CPU Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Processor</h3>
                        <h2 class="text-lg font-bold text-gray-800 dark:text-white">{{ $resource['cpu'] }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 mt-1">
                            {{ $resource['cpu-count'] }} cores @ {{ $resource['cpu-frequency'] }} MHz
                        </p>
                    </div>
                </div>
            </div>

            <!-- Version Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="p-3 bg-green-100 dark:bg-green-900/50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">System Version</h3>
                        <h2 class="text-lg font-bold text-gray-800 dark:text-white">{{ $resource['version'] }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 mt-1">
                            Built on {{ $resource['build-time'] }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Uptime Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="p-3 bg-amber-100 dark:bg-amber-900/50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">System Uptime</h3>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $resource['uptime'] }}</h2>
                    </div>
                </div>
            </div>

            <!-- Storage Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="p-3 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Storage</h3>
                        <div class="mt-2">
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300 mb-1">
                                <span>Used: {{ $resource['free-hdd-space'] }}</span>
                                <span>Total: {{ $resource['total-hdd-space'] }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                <div class="bg-indigo-600 dark:bg-indigo-500 h-2.5 rounded-full" style="width: 75%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Memory Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-md p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="p-3 bg-red-100 dark:bg-red-900/50 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Memory</h3>
                        <div class="mt-2">
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300 mb-1">
                                <span>Used: {{ $resource['free-memory'] }}</span>
                                <span>Total: {{ $resource['total-memory'] }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                <div class="bg-red-600 dark:bg-red-500 h-2.5 rounded-full" style="width: 60%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-md p-8 text-center border border-gray-100 dark:border-gray-700 max-w-md mx-auto">
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/50 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Connection Error</h3>
        <p class="mt-2 text-gray-600 dark:text-gray-300">Could not load device information</p>
        <p class="mt-2 text-red-500 dark:text-red-400 font-medium">{{ $conn_error }}</p>
    </div>
@endif