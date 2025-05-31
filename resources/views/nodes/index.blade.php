<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900 ">
                Cluster Nodes
            </h2>
            <p class="mt-1 text-sm text-gray-500 ">
                Check The List of all Nodes on the cluster
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
        <!-- Status Overview -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-indigo-700 to-purple-700 rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-8 md:px-10 md:py-10 text-white">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold">Cluster Nodes</h2>
                            <p class="mt-2 text-indigo-100">{{ count($nodes) > 0 ? count($nodes) : 0 }} nodes in your Kubernetes cluster</p>
                        </div>
                        <div class="mt-4 md:mt-0 flex space-x-2">
                            @if (count($nodes) > 0)
                                @php
                                    $masterCount = 0;
                                    $workerCount = 0;
                                    foreach ($nodes as $node) {
                                        if ($node['master'] == 'true') {
                                            $masterCount++;
                                        } else {
                                            $workerCount++;
                                        }
                                    }
                                @endphp
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-900 bg-opacity-50 text-white">
                                    <span class="h-2 w-2 rounded-full bg-purple-400 mr-2"></span>
                                    {{ $masterCount }} Master
                                </span>
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-900 bg-opacity-50 text-white">
                                    <span class="h-2 w-2 rounded-full bg-blue-400 mr-2"></span>
                                    {{ $workerCount }} Worker
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
            <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Node Details</h3>
                    <p class="text-sm text-gray-500">
                        Complete information about all cluster nodes
                    </p>
                </div>
                <div class="bg-indigo-50 rounded-full p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                    </svg>
                </div>
            </div>

            <div class="p-6">
                @if (!isset($conn_error))
                    <!-- Node Cards for Small Screens -->
                    <div class="block md:hidden space-y-4">
                        @if (count($nodes) > 0)
                            @foreach ($nodes as $node)
                                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                                    <div class="{{ $node['master'] == 'true' ? 'bg-gradient-to-r from-purple-600 to-purple-800 text-white' : 'bg-gradient-to-r from-blue-600 to-blue-800 text-white' }} px-4 py-3">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <a href="{{ route('Nodes.show', $node['name']) }}" class="font-semibold text-white hover:text-white hover:underline">{{ $node['hostname'] }}</a>
                                            </div>
                                            <div>
                                                <span class="px-2 py-1 text-xs rounded-full bg-white {{ $node['master'] == 'true' ? 'text-purple-800' : 'text-blue-800' }}">
                                                    {{ $node['master'] == 'true' ? 'Master' : 'Worker' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-4 space-y-3 text-sm">
                                        <div class="flex justify-between">
                                            <span class="font-medium text-gray-500">Architecture:</span>
                                            <span>{{ $node['arch'] }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="font-medium text-gray-500">OS:</span>
                                            <span>{{ $node['os'] }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="font-medium text-gray-500">Instance:</span>
                                            <span>{{ $node['instance'] }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="font-medium text-gray-500">Pod CIDR:</span>
                                            <div class="flex flex-wrap justify-end">
                                                @foreach ($node['podCIDRs'] as $podCIDR)
                                                    <span class="inline-block bg-gray-100 rounded-full px-2 py-1 text-xs text-gray-700 mr-1 mb-1">{{ $podCIDR }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="font-medium text-gray-500">Status:</span>
                                            @if (isset($node['status']) && $node['status'] == "True")
                                                <span class="inline-flex items-center gap-1 text-green-700 bg-green-100 px-2.5 py-1 text-xs rounded-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                    Ready
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 text-red-700 bg-red-100 px-2.5 py-1 text-xs rounded-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728" />
                                                    </svg>
                                                    Not Ready
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Table for Medium and Larger Screens -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">Hostname</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Architecture</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">OS</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instance Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pod CIDR</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if (count($nodes) > 0)
                                    @foreach ($nodes as $node)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-md {{ $node['master'] == 'true' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <a href="{{ route('Nodes.show', $node['name']) }}" class="text-sm font-medium text-gray-900 hover:text-indigo-600">{{ $node['hostname'] }}</a>
                                                        <div class="text-xs text-gray-500">{{ $node['ip'] }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $node['master'] == 'true' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                    {{ $node['master'] == 'true' ? 'Master' : 'Worker' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $node['arch'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ $node['os'] }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $node['instance'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex flex-wrap">
                                                    @foreach ($node['podCIDRs'] as $podCIDR)
                                                        <span class="inline-block bg-indigo-50 text-indigo-700 rounded-full px-2.5 py-1 text-xs font-medium mr-1 mb-1">{{ $podCIDR }}</span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if (isset($node['status']) && $node['status'] == "True")
                                                    <span class="inline-flex items-center gap-1 text-green-700 bg-green-100 px-2.5 py-1 text-xs rounded-full">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        Ready
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 text-red-700 bg-red-100 px-2.5 py-1 text-xs rounded-full">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728" />
                                                        </svg>
                                                        Not Ready
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                            No nodes available in the cluster
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Refresh Button -->
                    <div class="mt-8 flex justify-center">
                        <a href="{{ route('Nodes.index') }}" class="refresh-nodes-btn inline-flex justify-center items-center px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                            <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span class="btn-text">Refresh Nodes</span>
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
                                Could not load cluster information. Error: <span class="font-medium">{{ $conn_error }}</span>
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('Nodes.index') }}" class="refresh-nodes-btn inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    <span class="btn-text">Try Again</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Node Statistics -->
        @if (!isset($conn_error) && count($nodes) > 0)
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $osDistribution = [];
                    $archDistribution = [];
                    $instanceTypes = [];
                    
                    foreach ($nodes as $node) {
                        // OS Distribution
                        if (!isset($osDistribution[$node['os']])) {
                            $osDistribution[$node['os']] = 0;
                        }
                        $osDistribution[$node['os']]++;
                        
                        // Architecture Distribution
                        if (!isset($archDistribution[$node['arch']])) {
                            $archDistribution[$node['arch']] = 0;
                        }
                        $archDistribution[$node['arch']]++;
                        
                        // Instance Types
                        if (!isset($instanceTypes[$node['instance']])) {
                            $instanceTypes[$node['instance']] = 0;
                        }
                        $instanceTypes[$node['instance']]++;
                    }
                @endphp
                
                <!-- OS Distribution -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900">Operating Systems</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach ($osDistribution as $os => $count)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-indigo-500 mr-3"></div>
                                        <span class="text-sm text-gray-700">{{ $os }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $count }} node(s)</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Architecture Distribution -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900">Architectures</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach ($archDistribution as $arch => $count)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-purple-500 mr-3"></div>
                                        <span class="text-sm text-gray-700">{{ $arch }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $count }} node(s)</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <!-- Instance Types -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900">Instance Types</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach ($instanceTypes as $instance => $count)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-blue-500 mr-3"></div>
                                        <span class="text-sm text-gray-700">{{ $instance }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $count }} node(s)</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>