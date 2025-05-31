<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900">
                Node Details
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Detailed information about the selected node
            </p>
        </div>
    </x-slot>

    <script>
        // Add loading indicator functionality
        document.addEventListener('DOMContentLoaded', function() {
            const refreshButtons = document.querySelectorAll('.refresh-nodes-btn');
            
            refreshButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Show loading state on the button
                    this.classList.add('opacity-75', 'cursor-not-allowed');
                    this.querySelector('.btn-text').textContent = 'Loading...';
                    
                    // Let the link continue its navigation
                    // The page will refresh with new data
                });
            });
        });
    </script>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Back to Nodes List -->
        <div class="mb-6">
            <a href="{{ route('Nodes.index') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Nodes List
            </a>
        </div>

        @if (!isset($conn_error) && $node)
            <!-- Node Overview Card -->
            <div class="mb-8">
                <div class="{{ $node['master'] == 'true' ? 'bg-gradient-to-r from-purple-600 to-purple-800' : 'bg-gradient-to-r from-blue-600 to-blue-800' }} rounded-2xl shadow-xl overflow-hidden">
                    <div class="px-6 py-8 md:px-10 md:py-10 text-white">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                            <div>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-white bg-opacity-20 p-2 rounded-lg mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-2xl font-bold">{{ $node['hostname'] }}</h2>
                                        <p class="mt-1 text-white text-opacity-80">{{ $node['ip'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white">
                                    {{ $node['master'] == 'true' ? 'Master Node' : 'Worker Node' }}
                                </span>
                                <span class="ml-2 inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $node['status'] == 'True' ? 'bg-green-500 bg-opacity-20 text-white' : 'bg-red-500 bg-opacity-20 text-white' }}">
                                    {{ $node['status'] == 'True' ? 'Ready' : 'Not Ready' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Node Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Basic Information -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900">Basic Information</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-500">Name:</span>
                            <span class="text-gray-900">{{ $node['name'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-500">Architecture:</span>
                            <span class="text-gray-900">{{ $node['arch'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-500">Operating System:</span>
                            <span class="text-gray-900">{{ $node['os'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-500">Instance Type:</span>
                            <span class="text-gray-900">{{ $node['instance'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-500">Created:</span>
                            <span class="text-gray-900">{{ \Carbon\Carbon::parse($node['creationTimestamp'])->format('M d, Y H:i:s') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Resources -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900">Resources</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-500">CPU:</span>
                            <span class="text-gray-900">{{ $node['cpus'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-500">Memory:</span>
                            <span class="text-gray-900">{{ $node['memory'] }} GB</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-500">Pods Capacity:</span>
                            <span class="text-gray-900">{{ $node['capacity']['pods'] ?? 'Unknown' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-500">Pods Allocatable:</span>
                            <span class="text-gray-900">{{ $node['allocatable']['pods'] ?? 'Unknown' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-500">Ephemeral Storage:</span>
                            <span class="text-gray-900">{{ isset($node['capacity']['ephemeral-storage']) ? round((int)str_replace('Ki', '', $node['capacity']['ephemeral-storage']) / 1024 / 1024, 1) . ' GB' : 'Unknown' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Network -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900">Network</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-500">IP Address:</span>
                            <span class="text-gray-900">{{ $node['ip'] }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-medium text-gray-500 mb-2">Pod CIDRs:</span>
                            <div class="space-y-2">
                                @foreach ($node['podCIDRs'] as $podCIDR)
                                    <span class="inline-block bg-indigo-50 text-indigo-700 rounded-full px-2.5 py-1 text-xs font-medium">{{ $podCIDR }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Node Conditions -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 mb-8">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-900">Node Conditions</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Transition</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($node['conditions'] as $condition)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $condition['type'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $condition['status'] == 'True' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $condition['status'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($condition['lastTransitionTime'])->format('M d, Y H:i:s') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $condition['reason'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $condition['message'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Images on Node -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Container Images</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                        {{ count($node['images']) }} images
                    </span>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($node['images'] as $image)
                                @foreach ($image['names'] as $name)
                                    <tr>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ round($image['sizeBytes'] / 1024 / 1024, 2) }} MB</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Refresh Button -->
            <div class="mt-8 flex justify-center">
                <a href="{{ route('Nodes.show', $node['name']) }}" class="refresh-nodes-btn inline-flex justify-center items-center px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                    <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span class="btn-text">Refresh Node Details</span>
                </a>
            </div>
        @else
            <!-- Error Message -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-6 flex items-center">
                <div class="flex-shrink-0 bg-red-100 rounded-full p-3">
                    <svg class="h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-red-800">Connection Error</h3>
                    <p class="mt-1 text-sm text-red-700">
                        Could not load node information. Error: <span class="font-medium">{{ $conn_error }}</span>
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('Nodes.index') }}" class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to Nodes List
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>