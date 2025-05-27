<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 Dashboard">
                    {{ __('Kubernetes Clusters') }}
                </h2>
                <p class="text-sm text-gray-500 Dashboard mt-1">
                    Manage your connected clusters
                </p>
            </div>
            <a href="{{ route('Clusters.create') }}" class="flex items-center space-x-2 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                <span>Add new Cluster</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            @if ($clusters == null)
            <div class="bg-gradient-to-br from-white to-gray-50 Dashboard Dashboard rounded-xl shadow-lg overflow-hidden border border-gray-100 Dashboard">
                <div class="p-8 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100 Dashboard">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 Dashboard">No Clusters Found</h4>
                    <p class="mt-2 text-gray-600 Dashboard">
                        Get started by adding your first cluster
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('Clusters.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 border border-transparent rounded-md font-medium text-white shadow-sm hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                            Add Cluster
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="grid grid-cols-1 gap-6">
                @foreach ($clusters as $cluster)
                <div class="bg-gradient-to-br from-white to-gray-50 Dashboard Dashboard rounded-xl shadow-lg overflow-hidden border border-gray-100 Dashboard transition-all hover:shadow-xl">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-gray-800 Dashboard" id="{{ $cluster['name'] }}">
                                    {{ $cluster['name'] }}'s Info
                                </h4>
                                <div class="flex items-center mt-1">
                                    @if ($cluster['online'])
                                    <span class="flex w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                                    <span class="text-sm text-green-600 Dashboard font-medium">Online</span>
                                    @else
                                    <span class="flex w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                    <span class="text-sm text-red-600 Dashboard font-medium">Unreachable</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('Clusters.edit', $cluster['id']) }}" class="p-2 text-gray-500 hover:text-blue-600  transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 Dashboard uppercase tracking-wider">
                                        Auth Type
                                    </p>
                                    <p class="mt-1 text-gray-800 ">
                                        {{ $cluster['auth_type'] == 'T' ? 'Token' : 'Proxy' }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 Dashboard uppercase tracking-wider">
                                        Timeout
                                    </p>
                                    <p class="mt-1 text-gray-800 ">
                                        {{ $cluster['timeout'] }} seconds
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex flex-col justify-between">
                                @if ($cluster['online'])
                                <div class="space-y-3">
                                    <a class="block w-full px-4 py-3 rounded-lg shadow text-center font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all
                                        {{ session('clusterId') == $cluster['id'] ? 'bg-gradient-to-r from-gray-600 to-gray-800 hover:from-gray-700 hover:to-gray-900 focus:ring-gray-500' : 'bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:ring-indigo-500' }}" 
                                        href="{{ route('Clusters.selectCluster', $cluster['id']) }}">
                                        {{ session('clusterId') == $cluster['id'] ? 'Current Cluster' : 'Use this cluster' }}
                                    </a>
                                    <a class="block w-full px-4 py-3 bg-gradient-to-r from-yellow-500 to-amber-500 rounded-lg shadow text-center font-medium text-white hover:from-yellow-600 hover:to-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all"
                                        href="{{ route('Clusters.edit', $cluster['id']) }}">
                                        Configure
                                    </a>
                                </div>
                                @else
                                <div class="space-y-3">
                                    <div class="p-3 bg-gray-100  rounded-lg">
                                        <p class="text-sm font-medium text-gray-500 Dashboard uppercase tracking-wider mb-1">
                                            Error Reason
                                        </p>
                                        <p class="text-sm text-yellow-600 ">
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
                                    <a class="block w-full px-4 py-3 bg-gradient-to-r from-gray-200 to-gray-300 rounded-lg shadow text-center font-medium text-gray-800 hover:from-gray-300 hover:to-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all"
                                        href="{{ route('Clusters.edit', $cluster['id']) }}">
                                        Edit Configuration
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</x-app-layout>