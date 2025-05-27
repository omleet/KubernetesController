<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ __('Update Cluster') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Update this Cluster
                </p>
            </div>
        </div>
    </x-slot>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ authType: '{{ old('auth_type', $cluster['auth_type']) }}' }">
        
        <!-- Update Cluster Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">Update Kubernetes Cluster</h2>
                <p class="text-blue-100 mt-1">
                    Modify your cluster configuration
                </p>
            </div>
            <div class="p-6">
                <p class="text-gray-600 mb-6">
                    Here you can update a Kubernetes Cluster
                    <br>
                    If you want to use a Token, check the documentation guide to <a href="https://kubernetes.io/docs/tasks/administer-cluster/access-cluster-api/?amp;amp#without-kubectl-proxy" class="text-blue-500 hover:text-blue-700">Access Clusters Using the Kubernetes API</a>.
                </p>
                
                <form method="POST" action="{{route('Clusters.update',$cluster['id'])}}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Name Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="name" class="focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2 border border-gray-300 rounded-md @error('name') border-red-500 @enderror" value="{{ old('name', $cluster['name']) }}" placeholder="My Cluster">
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Endpoint *</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="endpoint" class="focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2 border border-gray-300 rounded-md @error('endpoint') border-red-500 @enderror" value="{{ old('endpoint', $cluster['endpoint']) }}" placeholder="https://172.29.176.1:16443">
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
                                <option value="P" {{ old('auth_type', $cluster['auth_type']) == 'P' ? 'selected' : '' }}>Proxy (No authentication)</option>
                                <option value="T" {{ old('auth_type', $cluster['auth_type']) == 'T' ? 'selected' : '' }}>Token (Bearer authentication)</option>
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
                            <textarea name="token" rows="3" class="focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2 border border-gray-300 rounded-md @error('token') border-red-500 @enderror" placeholder="Paste your token here">{{ old('token') }}</textarea>
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Timeout</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="timeout" class="focus:ring-blue-500 focus:border-blue-500 block w-full px-4 py-2 border border-gray-300 rounded-md @error('timeout') border-red-500 @enderror" value="{{ old('timeout', $cluster['timeout']) }}" placeholder="5">
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

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        <a href="{{ url()->previous() }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Update Cluster
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Cluster Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-red-600 to-red-800 px-6 py-4">
                <h2 class="text-2xl font-bold text-white">Delete</h2>
            </div>
            <div class="p-6">
                <form method="POST" action="{{route ('Clusters.destroy',$cluster['id'])}}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <div class="flex flex-col">
                        <p class="text-gray-600 mb-4">This action cannot be undone. This will permanently delete the cluster configuration.</p>
                        <button type="button" onclick="_delete('Are you sure you want to delete this Cluster?','{{ route("Clusters.destroy", $cluster["id"]) }}')" class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Delete this Cluster
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Alpine.js for conditional fields -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>