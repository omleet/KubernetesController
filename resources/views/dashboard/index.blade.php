<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __('Kubernetes Dashboard') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Cluster overview and recent events
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Status Overview -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-indigo-700 to-purple-700 rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-8 md:px-10 md:py-10 text-white">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold">{{ isset($clusterInfo) ? $clusterInfo['name'] : 'Kubernetes Cluster' }}</h2>
                            <p class="mt-2 text-indigo-100">{{ isset($nodes) ? count($nodes) : 0 }} nodes in your Kubernetes cluster</p>
                            @if(isset($clusterInfo))
                            <div class="mt-3 flex flex-wrap gap-2">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-900 bg-opacity-50 text-white">
                                    Version: {{ $clusterInfo['version'] }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-900 bg-opacity-50 text-white">
                                    Platform: {{ $clusterInfo['platform'] }}
                                </span>
                            </div>
                            @endif
                        </div>
                        <div class="mt-4 md:mt-0 flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-900 bg-opacity-50 text-white">
                                <span class="h-2 w-2 rounded-full bg-green-400 mr-2"></span>
                                {{ isset($resources) ? $resources['pods'] : 0 }} Pods
                            </span>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-900 bg-opacity-50 text-white">
                                <span class="h-2 w-2 rounded-full bg-blue-400 mr-2"></span>
                                {{ isset($resources) ? $resources['services'] : 0 }} Services
                            </span>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-900 bg-opacity-50 text-white">
                                <span class="h-2 w-2 rounded-full bg-purple-400 mr-2"></span>
                                {{ isset($resources) ? $resources['deployments'] : 0 }} Deployments
                            </span>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-900 bg-opacity-50 text-white">
                                <span class="h-2 w-2 rounded-full bg-yellow-400 mr-2"></span>
                                {{ isset($resources) ? $resources['namespaces'] : 0 }} Namespaces
                            </span>
                            
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-900 bg-opacity-50 text-white">
                                <span class="h-2 w-2 rounded-full bg-pink-400 mr-2"></span>
                                {{ isset($resources) ? $resources['ingresses'] : 0 }} Ingresses
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Nodes Section -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Nodes Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Cluster Nodes</h3>
                            <p class="text-sm text-gray-500">
                                {{ isset($nodes) ? count($nodes) : 0 }} node(s) in cluster
                            </p>
                        </div>
                        <div class="bg-indigo-50 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                            </svg>
                        </div>
                    </div>

                    <div class="p-6">
                        @if(isset($nodes) && count($nodes) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                            @foreach ($nodes as $node)
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition transform hover:scale-[1.01] overflow-hidden">
                                <div class="{{ $node['master'] ? 'bg-gradient-to-r from-gray-800 to-gray-900 text-white' : 'bg-gradient-to-r from-indigo-50 to-blue-50 text-gray-800' }} p-4">
                                    <div class="flex justify-between items-center">
                                        <div class="font-semibold text-base">
                                            {{ $node['name'] }}
                                        </div>
                                        <div>
                                            @if(isset($node['status']) && $node['status'] == 'True')
                                            <span class="inline-flex items-center gap-1 text-green-700 bg-green-100 px-2.5 py-1 text-xs rounded-full" title="Node is active">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                Online
                                            </span>
                                            @else
                                            <span class="inline-flex items-center gap-1 text-red-800 bg-red-100 px-2.5 py-1 text-xs rounded-full" title="Node está offline">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728" />
                                                </svg>
                                                Offline
                                            </span>

                                            @endif
                                        </div>
                                    </div>
                                    <div class="mt-2 text-xs {{ $node['master'] ? 'text-gray-300' : 'text-gray-600' }}">
                                        {{ $node['master'] ? 'Control Plane' : 'Worker Node' }}
                                    </div>
                                </div>

                                <div class="p-4">
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div class="space-y-3">
                                            <div>
                                                <div class="text-xs text-gray-500">IP Address</div>
                                                <div class="font-medium text-gray-800">{{ $node['ip'] }}</div>
                                            </div>
                                            <div>
                                                <div class="text-xs text-gray-500">Pod CIDR</div>
                                                <div class="font-medium text-gray-800">{{ $node['podCidr'] }}</div>
                                            </div>
                                            <div>
                                                <div class="text-xs text-gray-500">Operating System</div>
                                                <div class="inline-block bg-blue-50 text-blue-700 text-xs px-2 py-1 rounded-md font-medium">
                                                    {{ ucfirst($node['os']) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-y-3">
                                            <div>
                                                <div class="text-xs text-gray-500">CPU</div>
                                                <div class="font-medium text-gray-800">{{ $node['cpus'] }} ({{ $node['arch'] }})</div>
                                                @if(isset($resourceUsage) && $resourceUsage['hasMetrics'] && isset($resourceUsage['nodeMetrics'][$node['name']]))
                                                <div class="mt-1">
                                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                        @php
                                                            $cpuPercent = min(100, ($resourceUsage['nodeMetrics'][$node['name']]['cpuUsage'] / (int)$node['cpus']) * 100);
                                                        @endphp
                                                        <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $cpuPercent }}%"></div>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-0.5">{{ $resourceUsage['nodeMetrics'][$node['name']]['cpuUsage'] }} cores used</div>
                                                </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-xs text-gray-500">Memory</div>
                                                <div class="font-medium text-gray-800">~{{ $node['memory'] }}GB</div>
                                                @if(isset($resourceUsage) && $resourceUsage['hasMetrics'] && isset($resourceUsage['nodeMetrics'][$node['name']]))
                                                <div class="mt-1">
                                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                                        @php
                                                            $memoryGB = $resourceUsage['nodeMetrics'][$node['name']]['memoryUsage'] / 1024;
                                                            $memoryPercent = min(100, ($memoryGB / $node['memory']) * 100);
                                                        @endphp
                                                        <div class="bg-green-600 h-1.5 rounded-full" style="width: {{ $memoryPercent }}%"></div>
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-0.5">{{ round($memoryGB, 1) }}GB used</div>
                                                </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-xs text-gray-500">Role</div>
                                                <div class="font-medium {{ $node['master'] ? 'text-indigo-700' : 'text-gray-700' }}">
                                                    {{ $node['master'] ? 'Control Plane' : 'Worker' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-4 text-gray-500 font-medium">No nodes available</p>
                            @if(isset($conn_error))
                            <p class="mt-2 text-red-500 text-sm">Error: {{ $conn_error }}</p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Resources Section -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Resources Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-white">Cluster Resources</h3>
                            <p class="text-sm text-indigo-100">
                                {{ $resources['namespaces'] + $resources['pods'] + $resources['deployments'] + $resources['services'] + $resources['ingresses'] }} total resources
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Resource Donut Chart -->
                        <div class="mb-6 flex flex-col items-center">
                            <div class="relative w-48 h-48">
                                <svg viewBox="0 0 36 36" class="w-full h-full">
                                    <!-- Background circle -->
                                    <circle cx="18" cy="18" r="15.91549430918954" fill="transparent" stroke="#f3f4f6" stroke-width="3"></circle>
                                    
                                    <!-- Namespaces segment -->
                                    @php
                                        $total = $resources['namespaces'] + $resources['pods'] + $resources['deployments'] + $resources['services'] + $resources['ingresses'];
                                        $namespacePercent = $total > 0 ? ($resources['namespaces'] / $total) * 100 : 0;
                                        $namespaceOffset = 0;
                                        $namespaceStrokeDasharray = (($namespacePercent / 100) * 100) . ' ' . (100 - ($namespacePercent / 100) * 100);
                                    @endphp
                                    <circle cx="18" cy="18" r="15.91549430918954" fill="transparent" stroke="#3b82f6" stroke-width="3" 
                                        stroke-dasharray="{{ $namespaceStrokeDasharray }}" stroke-dashoffset="{{ $namespaceOffset }}" class="donut-segment"></circle>
                                    
                                    <!-- Pods segment -->
                                    @php
                                        $podPercent = $total > 0 ? ($resources['pods'] / $total) * 100 : 0;
                                        $podOffset = -1 * ($namespacePercent / 100) * 100;
                                        $podStrokeDasharray = (($podPercent / 100) * 100) . ' ' . (100 - ($podPercent / 100) * 100);
                                    @endphp
                                    <circle cx="18" cy="18" r="15.91549430918954" fill="transparent" stroke="#10b981" stroke-width="3" 
                                        stroke-dasharray="{{ $podStrokeDasharray }}" stroke-dashoffset="{{ $podOffset }}" class="donut-segment"></circle>
                                    
                                    <!-- Deployments segment -->
                                    @php
                                        $deployPercent = $total > 0 ? ($resources['deployments'] / $total) * 100 : 0;
                                        $deployOffset = -1 * (($namespacePercent + $podPercent) / 100) * 100;
                                        $deployStrokeDasharray = (($deployPercent / 100) * 100) . ' ' . (100 - ($deployPercent / 100) * 100);
                                    @endphp
                                    <circle cx="18" cy="18" r="15.91549430918954" fill="transparent" stroke="#8b5cf6" stroke-width="3" 
                                        stroke-dasharray="{{ $deployStrokeDasharray }}" stroke-dashoffset="{{ $deployOffset }}" class="donut-segment"></circle>
                                    
                                    <!-- Services segment -->
                                    @php
                                        $servicePercent = $total > 0 ? ($resources['services'] / $total) * 100 : 0;
                                        $serviceOffset = -1 * (($namespacePercent + $podPercent + $deployPercent) / 100) * 100;
                                        $serviceStrokeDasharray = (($servicePercent / 100) * 100) . ' ' . (100 - ($servicePercent / 100) * 100);
                                    @endphp
                                    <circle cx="18" cy="18" r="15.91549430918954" fill="transparent" stroke="#f59e0b" stroke-width="3" 
                                        stroke-dasharray="{{ $serviceStrokeDasharray }}" stroke-dashoffset="{{ $serviceOffset }}" class="donut-segment"></circle>
                                    
                                    <!-- Ingresses segment -->
                                    @php
                                        $ingressPercent = $total > 0 ? ($resources['ingresses'] / $total) * 100 : 0;
                                        $ingressOffset = -1 * (($namespacePercent + $podPercent + $deployPercent + $servicePercent) / 100) * 100;
                                        $ingressStrokeDasharray = (($ingressPercent / 100) * 100) . ' ' . (100 - ($ingressPercent / 100) * 100);
                                    @endphp
                                    <circle cx="18" cy="18" r="15.91549430918954" fill="transparent" stroke="#ec4899" stroke-width="3" 
                                        stroke-dasharray="{{ $ingressStrokeDasharray }}" stroke-dashoffset="{{ $ingressOffset }}" class="donut-segment"></circle>
                                    
                                    <!-- Center text -->
                                    <g class="chart-text">
                                        <text x="18" y="17" class="chart-number" text-anchor="middle" alignment-baseline="middle" font-size="7" font-weight="bold">
                                            {{ $total }}
                                        </text>
                                        <text x="18" y="22" class="chart-label" text-anchor="middle" alignment-baseline="middle" font-size="2.5">
                                            RESOURCES
                                        </text>
                                    </g>
                                </svg>
                            </div>
                        </div>

                        <!-- Resource Cards -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-50 rounded-xl p-4 border border-blue-100 transition-all duration-300 hover:shadow-md hover:scale-[1.02]">
                                <div class="flex items-center mb-2">
                                    <div class="bg-blue-500 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="text-blue-800 font-medium">Namespaces</div>
                                </div>
                                <div class="text-3xl font-bold text-blue-900 ml-9">{{ $resources['namespaces'] }}</div>
                            </div>

                            <div class="bg-green-50 rounded-xl p-4 border border-green-100 transition-all duration-300 hover:shadow-md hover:scale-[1.02]">
                                <div class="flex items-center mb-2">
                                    <div class="bg-green-500 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                                        </svg>
                                    </div>
                                    <div class="text-green-800 font-medium">Pods</div>
                                </div>
                                <div class="text-3xl font-bold text-green-900 ml-9">{{ $resources['pods'] }}</div>
                            </div>

                            <div class="bg-purple-50 rounded-xl p-4 border border-purple-100 transition-all duration-300 hover:shadow-md hover:scale-[1.02]">
                                <div class="flex items-center mb-2">
                                    <div class="bg-purple-500 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <div class="text-purple-800 font-medium">Deployments</div>
                                </div>
                                <div class="text-3xl font-bold text-purple-900 ml-9">{{ $resources['deployments'] }}</div>
                            </div>

                            <div class="bg-amber-50 rounded-xl p-4 border border-amber-100 transition-all duration-300 hover:shadow-md hover:scale-[1.02]">
                                <div class="flex items-center mb-2">
                                    <div class="bg-amber-500 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <div class="text-amber-800 font-medium">Services</div>
                                </div>
                                <div class="text-3xl font-bold text-amber-900 ml-9">{{ $resources['services'] }}</div>
                            </div>
                            
                            <div class="col-span-2 bg-pink-50 rounded-xl p-4 border border-pink-100 transition-all duration-300 hover:shadow-md hover:scale-[1.02]">
                                <div class="flex items-center mb-2">
                                    <div class="bg-pink-500 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                    </div>
                                    <div class="text-pink-800 font-medium">Ingresses</div>
                                </div>
                                <div class="text-3xl font-bold text-pink-900 ml-9">{{ $resources['ingresses'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Persistent Volumes Section -->
        @if(isset($persistentVolumes) && count($persistentVolumes) > 0)
        <div class="mt-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Persistent Volumes</h3>
                        <p class="text-sm text-gray-500">
                            {{ count($persistentVolumes) }} persistent volume(s) in cluster
                        </p>
                    </div>
                    <div class="bg-indigo-50 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 rounded-tl-lg">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Capacity</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Access Modes</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Storage Class</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 rounded-tr-lg">Claim</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($persistentVolumes as $volume)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $volume['name'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $volume['capacity'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        @foreach($volume['accessModes'] as $mode)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1">
                                            {{ $mode }}
                                        </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            {{ $volume['status'] == 'Bound' ? 'bg-green-100 text-green-800' : 
                                              ($volume['status'] == 'Available' ? 'bg-blue-100 text-blue-800' : 
                                              'bg-yellow-100 text-yellow-800') }}">
                                            {{ $volume['status'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $volume['storageClass'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $volume['claim'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Ingresses Section -->
        @if(isset($ingresses) && count($ingresses) > 0)
        <div class="mt-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Ingress Routes</h3>
                        <p class="text-sm text-gray-500">
                            {{ count($ingresses) }} ingress(es) exposing services
                        </p>
                    </div>
                    <div class="bg-indigo-50 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($ingresses as $ingress)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition overflow-hidden">
                            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 p-4 border-b border-gray-100">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $ingress['name'] }}</div>
                                        <div class="text-xs text-gray-500">Namespace: {{ $ingress['namespace'] }}</div>
                                    </div>
                                    <div>
                                        @if($ingress['tls'])
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            TLS Enabled
                                        </span>
                                        @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            HTTP Only
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                @if(count($ingress['hosts']) > 0)
                                <div class="mb-4">
                                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Hosts</div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($ingress['hosts'] as $host)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ $host }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                
                                @if(count($ingress['paths']) > 0)
                                <div>
                                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Paths</div>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Path</th>
                                                    <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Type</th>
                                                    <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Service</th>
                                                    <th scope="col" class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Port</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($ingress['paths'] as $path)
                                                <tr>
                                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $path['path'] }}</td>
                                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">{{ $path['pathType'] }}</td>
                                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900">{{ $path['serviceName'] }}</td>
                                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">{{ $path['servicePort'] }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Recent Events Section -->
        <div class="mt-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Recent Events</h3>
                        <p class="text-sm text-gray-500">
                            Latest cluster activity
                        </p>
                    </div>
                    <div class="bg-indigo-50 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="p-6">
                    @if (!isset($conn_error) && $events)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 rounded-tl-lg">Time</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Kind</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Object</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">Type</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 rounded-tr-lg">Message</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if ($events != null)
                                @foreach ($events['data'] as $event)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    @if($event['time'] != null)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $event['time'] }}</td>
                                    @else
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <div>From: {{ $event['startTime'] }}</div>
                                        <div>To: {{ $event['endTime'] }}</div>
                                    </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $event['kind'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $event['name'] . '@' . $event['namespace'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $event['type'] == 'Normal' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $event['type'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $event['message'] }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-6 flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                Showing {{ ($events['current_page'] - 1) * $events['per_page'] + 1 }} to
                                {{ min($events['current_page'] * $events['per_page'], $events['total']) }} of
                                {{ $events['total'] }} events
                            </div>

                            <div class="flex space-x-2">
                                @if ($events['current_page'] > 1)
                                <a href="?page={{ $events['current_page'] - 1 }}"
                                    class="px-3 py-1.5 border rounded-md text-indigo-600 border-indigo-200 hover:bg-indigo-50 transition">
                                    Previous
                                </a>
                                @endif

                                @for ($i = 1; $i <= min(5, $events['last_page']); $i++)
                                    <a href="?page={{ $i }}"
                                    class="px-3 py-1.5 border rounded-md {{ $i == $events['current_page'] ? 'bg-indigo-600 text-white border-indigo-600' : 'text-indigo-600 border-indigo-200 hover:bg-indigo-50' }} transition">
                                    {{ $i }}
                                    </a>
                                    @endfor

                                    @if ($events['current_page'] < $events['last_page'])
                                        <a href="?page={{ $events['current_page'] + 1 }}"
                                        class="px-3 py-1.5 border rounded-md text-indigo-600 border-indigo-200 hover:bg-indigo-50 transition">
                                        Next
                                        </a>
                                        @endif
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    Could not load cluster information. Error: {{ $conn_error }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>