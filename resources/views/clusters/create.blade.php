<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">
            {{ __('Add New Kubernetes Cluster') }}
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Configure access to your Kubernetes cluster
        </p>
    </div>
</div>
    </x-slot>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">Add New Kubernetes Cluster</h2>
                <p class="text-blue-100 mt-1">
                    Configure access to your Kubernetes cluster
                </p>
            </div>

            <!-- Form Section -->
            <div class="p-6" x-data="{ authType: '{{ old('auth_type', 'P') }}' }">
                <form method="POST" action="{{route('Clusters.store')}}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Name Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cluster Name *</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="name" class="focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2 border border-gray-300 rounded-md @error('name') border-red-500 @enderror" value="{{old('name')}}" placeholder="e.g. Production Cluster">
                            @error('name')
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @enderror
                        </div>
                        @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Endpoint Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">API Endpoint *</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="endpoint" class="focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2 border border-gray-300 rounded-md @error('endpoint') border-red-500 @enderror" value="{{old('endpoint') ?? 'https://172.29.176.1:16443'}}" placeholder="https://172.29.176.1:16443">
                            @error('endpoint')
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @enderror
                        </div>
                        @error('endpoint')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                     <!-- Auth Type Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Authentication Method *</label>
                        <div class="mt-1">
                            <select name="auth_type" x-model="authType" class="focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2 border border-gray-300 rounded-md @error('auth_type') border-red-500 @enderror">
                                <option value="P" {{old('token') == 'P' ? 'selected' : ''}}>Proxy (No authentication)</option>
                                <option value="T" {{old('token') == 'T' ? 'selected' : ''}}>Token (Bearer authentication)</option>
                            </select>
                        </div>
                        @error('auth_type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Token Field (Conditional) -->
                    <div x-show="authType === 'T'" x-transition>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bearer Token</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <textarea name="token" rows="3" class="focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2 border border-gray-300 rounded-md @error('token') border-red-500 @enderror" placeholder="Paste your token here">{{old('token')}}</textarea>
                            @error('token')
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @enderror
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            For security reasons, the token will be encrypted when stored.
                        </p>
                        @error('token')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Timeout Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Connection Timeout (seconds)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" name="timeout" class="focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2 border border-gray-300 rounded-md @error('timeout') border-red-500 @enderror" value="{{old('timeout') ?? '5'}}" placeholder="5">
                            @error('timeout')
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            @enderror
                        </div>
                        @error('timeout')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Documentation Link -->
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Need help configuring your cluster? Check the <a href="https://kubernetes.io/docs/tasks/administer-cluster/access-cluster-api/?amp;amp#without-kubectl-proxy" class="font-medium text-blue-700 underline hover:text-blue-600">Kubernetes API Access documentation</a>.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        <a href="{{ url()->previous() }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Save Cluster Configuration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Alpine.js for conditional fields -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('form', () => ({
                authType: '{{ old('auth_type', 'P') }}'
            }))
        })
    </script>
</x-app-layout>