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
        <!-- Nodes and Resources Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Nodes Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden h-full flex flex-col">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">Cluster Nodes</h3>
                        <p class="text-blue-100 text-sm mt-1">
                            {{ isset($nodes) ? count($nodes) : 0 }} node(s) in cluster
                        </p>
                    </div>

                    <div class="p-6 flex-grow">
                        @if(isset($nodes) && count($nodes) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($nodes as $node)
                            <div class="bg-gray-50 rounded-xl shadow border border-gray-200 hover:shadow-md transition transform hover:scale-[1.01]">
                                <div class="{{ $node['master'] ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-800' }} p-4 rounded-t-xl">
                                    <div class="text-center font-semibold text-base">
                                        {{ $node['name'] }}
                                    </div>
                                    <div class="mt-1 flex justify-center items-center gap-2">
                                        @if(isset($node['status']) && $node['status'] == 'True')
                                        <span class="inline-flex items-center gap-1 text-green-700 bg-green-100 px-2 py-0.5 text-xs rounded-full" title="Este nó está ativo">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            Online
                                        </span>
                                        @else
                                        <span class="inline-flex items-center gap-1 text-red-700 bg-red-100 px-2 py-0.5 text-xs rounded-full" title="Este nó está inativo ou com falhas">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-2.293-5.707a1 1 0 011.414 0L10 13.586l.879-.879a1 1 0 111.414 1.414L11.414 15l.879.879a1 1 0 11-1.414 1.414L10 16.414l-.879.879a1 1 0 01-1.414-1.414L8.586 15l-.879-.879a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                            Offline
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-4 space-y-2 text-sm text-gray-700">
                                    <div class="flex justify-between items-center" title="Endereço IP do nó">
                                        <span class="font-medium">IP:</span>
                                        <span>{{ $node['ip'] }}</span>
                                    </div>
                                    <div class="flex justify-between items-center" title="CIDR atribuído aos pods">
                                        <span class="font-medium">Pods:</span>
                                        <span>{{ $node['podCidr'] }}</span>
                                    </div>
                                    <div class="flex justify-between items-center" title="Processadores e arquitetura">
                                        <span class="font-medium">CPU:</span>
                                        <span>{{ $node['cpus'] }} ({{ $node['arch'] }})</span>
                                    </div>
                                    <div class="flex justify-between items-center" title="Memória disponível">
                                        <span class="font-medium">RAM:</span>
                                        <span>~{{ $node['memory'] }}GB</span>
                                    </div>
                                    <div class="flex justify-between items-center" title="Sistema operativo do nó">
                                        <span class="font-medium">OS:</span>
                                        <span>
                                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                                {{ ucfirst($node['os']) }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center" title="Tipo de nó no cluster">
                                        <span class="font-medium">Tipo:</span>
                                        <span class="text-xs font-semibold {{ $node['master'] ? 'text-gray-800' : 'text-gray-600' }}">
                                            {{ $node['master'] ? 'Control Plane' : 'Worker' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No nodes available</p>
                            @if(isset($conn_error))
                            <p class="text-red-500 mt-2">Error: {{ $conn_error }}</p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>



            <!-- Resources -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden h-full flex flex-col">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                        <h3 class="text-lg font-medium text-white">
                            Cluster Resources
                        </h3>
                        <p class="text-blue-100 text-sm mt-1">
                            {{ $resources['namespaces'] + $resources['pods'] + $resources['deployments'] + $resources['services'] + $resources['ingresses'] }} total resources
                        </p>
                    </div>
                    <div class="p-6 flex-grow">
                        <!-- Resource Summary Cards -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                                <div class="text-blue-800 font-medium text-sm">Namespaces</div>
                                <div class="text-2xl font-bold text-blue-900 mt-1">{{ $resources['namespaces'] }}</div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                                <div class="text-green-800 font-medium text-sm">Pods</div>
                                <div class="text-2xl font-bold text-green-900 mt-1">{{ $resources['pods'] }}</div>
                            </div>
                            <div class="bg-purple-50 rounded-lg p-4 border border-purple-100">
                                <div class="text-purple-800 font-medium text-sm">Deployments</div>
                                <div class="text-2xl font-bold text-purple-900 mt-1">{{ $resources['deployments'] }}</div>
                            </div>
                            <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-100">
                                <div class="text-yellow-800 font-medium text-sm">Services</div>
                                <div class="text-2xl font-bold text-yellow-900 mt-1">{{ $resources['services'] }}</div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>

        <!-- Recent Events Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                <h3 class="text-lg font-medium text-white">Recent Events</h3>
                <p class="text-blue-100 text-sm mt-1">
                    Latest cluster activity
                </p>
            </div>
            <div class="p-6">
                @if (!isset($conn_error) && $events)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kind</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Object</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($events != null)
                            @foreach ($events['data'] as $event)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                @if($event['time'] != null)
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $event['time'] }}</td>
                                @else
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>From: {{ $event['startTime'] }}</div>
                                    <div>To: {{ $event['endTime'] }}</div>
                                </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $event['kind'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $event['name'] . '@' . $event['namespace'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $event['type'] == 'Normal' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $event['type'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $event['message'] }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                    <!-- Paginação -->
                    <div class="mt-4 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Mostrando {{ ($events['current_page'] - 1) * $events['per_page'] + 1 }} a
                            {{ min($events['current_page'] * $events['per_page'], $events['total']) }} de
                            {{ $events['total'] }} eventos
                        </div>

                        <div class="flex space-x-2">
                            @if ($events['current_page'] > 1)
                            <a href="?page={{ $events['current_page'] - 1 }}"
                                class="px-3 py-1 border rounded text-blue-600 border-blue-600 hover:bg-blue-50">
                                Anterior
                            </a>
                            @endif

                            @for ($i = 1; $i <= min(5, $events['last_page']); $i++)
                                <a href="?page={{ $i }}"
                                class="px-3 py-1 border rounded {{ $i == $events['current_page'] ? 'bg-blue-600 text-white border-blue-600' : 'text-blue-600 border-blue-600 hover:bg-blue-50' }}">
                                {{ $i }}
                                </a>
                                @endfor

                                @if ($events['current_page'] < $events['last_page'])
                                    <a href="?page={{ $events['current_page'] + 1 }}"
                                    class="px-3 py-1 border rounded text-blue-600 border-blue-600 hover:bg-blue-50">
                                    Próxima
                                    </a>
                                    @endif
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-red-50 border-l-4 border-red-400 p-4">
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

</x-app-layout>