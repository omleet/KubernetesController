<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('Kubernetes Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Nodes Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-full flex flex-col">
                        <div class="p-6 bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Nodes</h3>
                        </div>
                        <div class="p-6 flex-grow">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 justify-center">
                                @foreach ($nodes as $node)
                                <div class="flex flex-col h-full">
                                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden h-full flex flex-col border border-gray-200 dark:border-gray-700">
                                        <div class="{{$node['master'] ? 'bg-gray-900 text-white' : 'bg-gray-100 dark:bg-gray-700'}} p-3 text-center">
                                            <div class="font-medium">{{$node['name']}}</div>
                                            <div class="text-sm {{$node['master'] ? 'text-gray-300' : 'text-gray-500 dark:text-gray-400'}}">
                                                {{isset($node['status']) && $node['status'] == 'True' ? "Online" : "Offline"}}
                                            </div>
                                        </div>
                                        <?php
                                            switch(true) {
                                                case(preg_match('/\bdebian\b/i', $node['os'])):
                                                    $img = url('img/logos/debian.png');
                                                    break;
                                                case(preg_match('/\brocky\b/i', $node['os'])):
                                                    $img = url('img/logos/rocky.png');
                                                    break;
                                                default:
                                                    $img = url('img/logos/k8s.png');
                                            }
                                        ?>
                                        <div class="p-4 flex-grow">
                                            <div class="flex justify-center">
                                                <img src="{{$img}}" width="70" height="70" alt="OS Logo" class="mx-auto">
                                            </div>
                                            <p class="text-center text-gray-700 dark:text-gray-300 mt-2">{{$node['os']}}</p>
                                        </div>
                                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                            <li class="px-4 py-2"><p class="text-center font-medium text-gray-900 dark:text-white">{{$node['ip']}}</p></li>
                                            <li class="px-4 py-2"><p class="text-center font-medium text-gray-900 dark:text-white">{{$node['podCidr']}} (pods)</p></li>
                                            <li class="px-4 py-2"><p class="text-center font-medium text-gray-900 dark:text-white">{{$node['cpus']}} CPUs ({{$node['arch']}})</p></li>
                                            <li class="px-4 py-2"><p class="text-center font-medium text-gray-900 dark:text-white">~{{$node['memory']}}GBs</p></li>
                                        </ul>
                                        <div class="{{$node['master'] ? 'bg-gray-900 text-white' : 'bg-gray-100 dark:bg-gray-700'}} p-3 text-center">
                                            {{$node['master'] ? 'Control Plane' : 'Worker'}}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resources Chart -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-full">
                        <div class="p-6 bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                Total Resources ({{$resources['namespaces'] + $resources['pods'] + $resources['deployments'] + $resources['services'] + $resources['ingresses']}})
                            </h3>
                        </div>
                        <div class="p-6">
                            <canvas id="totalResources"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Events -->
            <div class="mt-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Recent events</h3>
                    </div>
                    <div class="p-6">
                        @if (!isset($conn_error))
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Time</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kind</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Object</th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Message</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @if ($events != null)
                                    @foreach ($events as $event)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        @if($event['time'] != null)
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-white">{{$event['time']}}</td>
                                        @else    
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            <div>From: {{$event['startTime']}}</div>
                                            <div>To: {{$event['endTime']}}</div>
                                        </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-white">{{$event['kind']}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-white">{{$event['name'] . '@' .$event['namespace']}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-900 dark:text-white">{{$event['type']}}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white text-justify">{{$event['message']}}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="p-4 text-red-600 dark:text-red-400">
                            <p>Could not load info.</p>
                            <p class="font-medium">Error: {{$conn_error}}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>