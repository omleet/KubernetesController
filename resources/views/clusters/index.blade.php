<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('Your Kubernetes Clusters') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($clusters == null)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">List of all your Clusters</h3>
                </div>
                <div class="p-6">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">You don't have any clusters yet</h4>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Try adding one using the button below
                    </p>
                </div>
            </div>
            @else
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-gray-100 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">List of all your Clusters</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($clusters as $cluster)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
                            <div class="p-6">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4" id="{{$cluster['name']}}">
                                    {{$cluster['name']}}'s Info
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <div class="mb-3">
                                            <p class="font-bold text-gray-900 dark:text-white">
                                                Auth Type
                                            </p>
                                            <p class="text-gray-700 dark:text-gray-300">
                                                {{$cluster['auth_type'] == 'T' ? 'Token' : 'Proxy' }}
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <p class="font-bold text-gray-900 dark:text-white">
                                                Communication timeout:
                                            </p>
                                            <p class="text-gray-700 dark:text-gray-300">
                                                {{$cluster['timeout']}} seconds
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        @if ($cluster['online'])
                                        <div class="mb-3">
                                            <p class="font-bold text-gray-900 dark:text-white">
                                                Status
                                            </p>
                                            <p class="text-green-600 dark:text-green-400">
                                                Online
                                            </p>
                                        </div>
                                        <div class="space-y-3">
                                            <a class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white {{ session('clusterId') == $cluster['id'] ? 'bg-gray-800 hover:bg-gray-900' : 'bg-indigo-600 hover:bg-indigo-700'}} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                href="{{ route ('Clusters.selectCluster', $cluster['id']) }}">
                                                {{ session('clusterId') == $cluster['id'] ? 'Current Cluster' : 'Use this cluster'}}
                                            </a>
                                            <a class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                href="{{ route ('Clusters.edit', $cluster['id']) }}">
                                                Edit this cluster
                                            </a>
                                        </div>
                                        @else
                                        <div class="mb-3">
                                            <p class="font-bold text-gray-900 dark:text-white">
                                                Status
                                            </p>
                                            <p class="text-red-600 dark:text-red-400">
                                                Unreachable
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <p class="font-bold text-gray-900 dark:text-white">
                                                Reason
                                            </p>
                                            <p class="text-yellow-600 dark:text-yellow-400">
                                                @switch($cluster['reason'])
                                                    @case(0)
                                                        Health check failed/request timed out
                                                        @break
                                                    @case(401)
                                                        Authentication Error (bad token/proxy error)
                                                        @break   
                                                    @default
                                                        Unknown error (HTTP code {{ $cluster['reason'] }})
                                                @endswitch
                                            </p>
                                        </div>
                                        <a class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            href="{{ route ('Clusters.edit', $cluster['id']) }}">
                                            Edit this cluster
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <div class="mt-6">
                <a href="{{ route ('Clusters.create') }}" class="w-full flex justify-center items-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add new Cluster
                </a>
            </div>
        </div>
    </div>
</x-app-layout>