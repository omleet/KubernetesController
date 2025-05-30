<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900">
                Pod: {{ $pod['name'] }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Detailed information about this Kubernetes pod
            </p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Action Bar -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    {{ $pod['status'] == 'Running' || $pod['status'] == 'Succeeded' ? 'bg-green-100 text-green-800' : 
                      ($pod['status'] == 'Pending' || $pod['status'] == 'Terminating' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    <svg class="mr-1.5 h-2 w-2 
                        {{ $pod['status'] == 'Running' || $pod['status'] == 'Succeeded' ? 'text-green-400' : 
                          ($pod['status'] == 'Pending' || $pod['status'] == 'Terminating' ? 'text-yellow-400' : 'text-red-400') }}" 
                        fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3" />
                    </svg>
                    {{ $pod['status'] ?? 'Unknown' }}
                </span>
                <span class="ml-3 text-sm text-gray-500">Created {{ $pod['creationTimestamp'] ?? '-' }}</span>
            </div>
            
            <div class="flex space-x-3">
                <a href="{{ route('Pods.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                    <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Pods
                </a>
                
                @if (!preg_match('/^kube-/', $pod['namespace']))
                    @if ((Auth::user()->resources == '[*]' || str_contains(Auth::user()->resources,'Pods')) && (Auth::user()->verbs == '[*]' || str_contains(Auth::user()->verbs,'Delete')) )
                    <button onclick="_delete('Are you sure you want to delete the Pod &quot;{{ $pod['name'] }}?','{{ route('Pods.destroy', [$pod['namespace'], $pod['name']]) }}')" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                        <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Delete Pod
                    </button>
                    @endif
                @endif
            </div>
        </div>

        <!-- Overview Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 mb-6">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex items-center">
                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-2">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-900">Pod Overview</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Basic information about this pod
                    </p>
                </div>
            </div>
            
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $pod['name'] ?? '-' }}</dd>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <dt class="text-sm font-medium text-gray-500">Namespace</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $pod['namespace'] ?? '-' }}</dd>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <dt class="text-sm font-medium text-gray-500">UID</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono break-all">{{ $pod['uid'] ?? '-' }}</dd>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                {{ $pod['status'] == 'Running' || $pod['status'] == 'Succeeded' ? 'bg-green-100 text-green-800' : 
                                  ($pod['status'] == 'Pending' || $pod['status'] == 'Terminating' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                <svg class="mr-1.5 h-4 w-4 
                                    {{ $pod['status'] == 'Running' || $pod['status'] == 'Succeeded' ? 'text-green-600' : 
                                      ($pod['status'] == 'Pending' || $pod['status'] == 'Terminating' ? 'text-yellow-600' : 'text-red-600') }}" 
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    @if($pod['status'] == 'Running' || $pod['status'] == 'Succeeded')
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    @elseif($pod['status'] == 'Pending' || $pod['status'] == 'Terminating')
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    @else
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    @endif
                                </svg>
                                {{ $pod['status'] ?? 'Unknown' }}
                            </span>
                        </dd>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <dt class="text-sm font-medium text-gray-500">Creation Date</dt>
                        <dd class="mt-1 text-sm text-gray-900 flex items-center">
                            <svg class="mr-1.5 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            {{ $pod['creationTimestamp'] ?? '-' }}
                        </dd>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <dt class="text-sm font-medium text-gray-500">Node</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $pod['nodeName'] ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Pod Details Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 mb-6">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex items-center">
                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-2">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H6a2 2 0 00-2 2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-900">Pod Details</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Network and policy information
                    </p>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Network Information</h3>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Host IP</dt>
                                <dd class="text-sm text-gray-900">{{ $pod['hostIp'] ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Pod IP</dt>
                                <dd class="text-sm text-gray-900">{{ $pod['podIp'] ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Policy Information</h3>
                        <dl class="space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Restart Policy</dt>
                                <dd class="text-sm text-gray-900">{{ $pod['restartPolicy'] ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm font-medium text-gray-500">Termination Grace Period</dt>
                                <dd class="text-sm text-gray-900">{{ $pod['terminationGracePeriodSeconds'] ?? '-' }} seconds</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Metadata Tabs -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 mb-6">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-2">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-900">Metadata</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Labels and annotations
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex" aria-label="Tabs">
                    <button onclick="showTab('labels')" class="tab-button w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm border-indigo-500 text-indigo-600" id="labels-tab">
                        Labels
                    </button>
                    <button onclick="showTab('annotations')" class="tab-button w-1/2 py-4 px-1 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" id="annotations-tab">
                        Annotations
                    </button>
                </nav>
            </div>
            
            <div class="p-6">
                <!-- Labels Tab -->
                <div id="labels-content" class="tab-content">
                    @if(isset($pod['labels']) && count($pod['labels']) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($pod['labels'] as $key => $label)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-indigo-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">{{ $key }}</span>
                                </div>
                                <div class="mt-2 pl-7">
                                    <span class="text-sm text-gray-700 break-all">{{ $label }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No labels</h3>
                            <p class="mt-1 text-sm text-gray-500">There are no labels on this pod.</p>
                        </div>
                    @endif
                </div>
                
                <!-- Annotations Tab -->
                <div id="annotations-content" class="tab-content hidden">
                    @if(isset($pod['annotations']) && count($pod['annotations']) > 0)
                        <div class="grid grid-cols-1 gap-4">
                            @foreach($pod['annotations'] as $key => $annotation)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-indigo-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v-1l1-1 1-1-.257-.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900 break-all">{{ $key }}</span>
                                </div>
                                <div class="mt-2 pl-7">
                                    <span class="text-sm text-gray-700 break-all">{{ $annotation }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No annotations</h3>
                            <p class="mt-1 text-sm text-gray-500">There are no annotations on this pod.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Containers Section -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 mb-6">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex items-center">
                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-2">
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-900">Containers</h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Information about containers in this pod
                    </p>
                </div>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 gap-6">
                    @foreach ($pod['containers'] as $key => $container)
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-2">
                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-medium text-gray-900">Container #{{ $key + 1 }}: {{ $container['name'] ?? 'Unnamed' }}</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Container Details</h4>
                                <dl class="space-y-2">
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Image</dt>
                                        <dd class="text-sm text-gray-900 text-right">{{ $container['image'] ?? '-' }}</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-sm font-medium text-gray-500">Image Pull Policy</dt>
                                        <dd class="text-sm text-gray-900 text-right">{{ $container['imagePullPolicy'] ?? '-' }}</dd>
                                    </div>
                                </dl>
                                
                                <h4 class="text-sm font-medium text-gray-500 mt-4 mb-2">Ports</h4>
                                @if (isset($container['ports']) && count($container['ports']) > 0)
                                    <div class="space-y-2">
                                        @foreach ($container['ports'] as $port)
                                        <div class="flex justify-between">
                                            <dt class="text-sm font-medium text-gray-500">Port</dt>
                                            <dd class="text-sm text-gray-900 text-right">{{ $port['containerPort'] ?? '-' }}/{{ $port['protocol'] ?? '-' }}</dd>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No ports configured</p>
                                @endif
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Environment Variables</h4>
                                @if (isset($container['env']) && count($container['env']) > 0)
                                    <div class="space-y-2">
                                        @foreach ($container['env'] as $env)
                                        <div class="flex justify-between">
                                            <dt class="text-sm font-medium text-gray-500">{{ $env['name'] }}</dt>
                                            <dd class="text-sm text-gray-900 text-right">{{ $env['value'] ?? '-' }}</dd>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No environment variables configured</p>
                                @endif
                                
                                <h4 class="text-sm font-medium text-gray-500 mt-4 mb-2">Volume Mounts</h4>
                                @if (isset($container['volumeMounts']) && count($container['volumeMounts']) > 0)
                                    <div class="space-y-2">
                                        @foreach ($container['volumeMounts'] as $volume)
                                        <div class="flex justify-between">
                                            <dt class="text-sm font-medium text-gray-500">
                                                {{ $volume['name'] ?? '-' }}
                                                @if(isset($volume['readOnly']) && $volume['readOnly'])
                                                <span class="text-xs text-red-500 ml-1">(RO)</span>
                                                @endif
                                            </dt>
                                            <dd class="text-sm text-gray-900 text-right">{{ $volume['mountPath'] ?? '-' }}</dd>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">No volume mounts configured</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- JSON Data Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-2">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-900">Raw JSON Data</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Complete pod configuration in JSON format
                        </p>
                    </div>
                </div>
                <button id="copy-json" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                    <svg class="-ml-0.5 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" />
                        <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z" />
                    </svg>
                    Copy JSON
                </button>
            </div>
            
            <div class="p-6">
                <div class="bg-gray-100 rounded-lg p-4 overflow-x-auto">
                    <pre id="json" class="text-green-500 text-sm font-mono">{{ $json }}</pre>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show the selected tab content
            document.getElementById(`${tabName}-content`).classList.remove('hidden');
            
            // Update tab button styles
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-indigo-500', 'text-indigo-600');
                button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            });
            
            document.getElementById(`${tabName}-tab`).classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            document.getElementById(`${tabName}-tab`).classList.add('border-indigo-500', 'text-indigo-600');
        }
        
        // Pretty print the JSON
        document.addEventListener('DOMContentLoaded', function() {
            const jsonElement = document.getElementById('json');
            if (jsonElement) {
                try {
                    const jsonData = JSON.parse(jsonElement.textContent);
                    jsonElement.textContent = JSON.stringify(jsonData, null, 2);
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                }
            }
            
            // Copy JSON functionality
            const copyButton = document.getElementById('copy-json');
            if (copyButton) {
                copyButton.addEventListener('click', function() {
                    const jsonText = document.getElementById('json').textContent;
                    navigator.clipboard.writeText(jsonText).then(function() {
                        const originalText = copyButton.innerHTML;
                        copyButton.innerHTML = `
                            <svg class="-ml-0.5 mr-2 h-4 w-4 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Copied!
                        `;
                        setTimeout(function() {
                            copyButton.innerHTML = originalText;
                        }, 2000);
                    }).catch(function(err) {
                        console.error('Could not copy text: ', err);
                    });
                });
            }
        });
    </script>
</x-app-layout>
