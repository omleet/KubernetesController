<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $device['name'] }} Resources
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Real-time monitoring and statistics
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                    <span class="w-2 h-2 mr-2 rounded-full bg-green-500 animate-pulse"></span>
                    Live updating
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 sm:p-8">
                    <!-- Resources Content -->
                    <div id="resources-container" class="transition-opacity duration-300">
                        @include('devices.partials.resources', ['resource' => $resource, 'conn_error' => $conn_error ?? null])
                    </div>

                    <!-- Footer with update info -->
                    <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Time: <span id="last-updated" class="font-medium text-gray-700 dark:text-gray-300">{{ now()->setTimezone('Europe/Lisbon')->format('H:i:s') }}</span></span>
                        </div>
                        <div class="text-xs text-gray-400 dark:text-gray-500">
                            Auto-refresh every 10 seconds
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Smooth reload with fade effect
    setInterval(function () {
        // Add fading effect before reload
        const container = document.getElementById('resources-container');
        container.style.opacity = '0.5';
        
        setTimeout(() => {
            location.reload();
        }, 300);
    }, 10000); // refresh every 10 seconds

    // Update the timestamp dynamically
    function updateTimestamp() {
        const now = new Date();
        const options = { 
            timeZone: 'Europe/Lisbon',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false
        };
        document.getElementById('last-updated').textContent = now.toLocaleTimeString('en-GB', options);
    }
    
    // Update timestamp every second for better accuracy
    setInterval(updateTimestamp, 1000);
</script>