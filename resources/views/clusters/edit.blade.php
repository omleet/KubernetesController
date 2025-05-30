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

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Main Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <!-- Header Section -->
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-900">Update Cluster Configuration</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Modify the details of your Kubernetes cluster
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="p-6" x-data="{ authType: '{{ old('auth_type', $cluster['auth_type']) }}' }">
                <form method="POST" action="{{route('Clusters.update',$cluster['id'])}}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Form Steps Indicator -->
                    <div class="mb-8">
                        <nav aria-label="Progress">
                            <ol role="list" class="overflow-hidden">
                                <div class="relative flex items-center justify-between">
                                    <!-- Line connecting steps -->
                                    <div class="absolute inset-x-0 top-1/3 h-0.5 -translate-y-1/2 bg-gray-200 z-0 mx-10"></div>

                                    <!-- Step 1: Basic Info -->
                                    <li class="relative z-10">
                                        <div class="flex flex-col items-center">
                                            <div class="flex items-center justify-center w-10 h-10 bg-indigo-600 rounded-full">
                                                <span class="flex items-center justify-center w-8 h-8 bg-indigo-600 rounded-full">
                                                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <span class="mt-2 text-sm font-medium text-gray-900">Basic Info</span>
                                        </div>
                                    </li>

                                    <!-- Step 2: Authentication -->
                                    <li class="relative z-10">
                                        <div class="flex flex-col items-center">
                                            <div class="flex items-center justify-center w-10 h-10 bg-indigo-600 rounded-full">
                                                <span class="flex items-center justify-center w-8 h-8 bg-indigo-600 rounded-full">
                                                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <span class="mt-2 text-sm font-medium text-gray-900">Authentication</span>
                                        </div>
                                    </li>

                                    <!-- Step 3: Advanced -->
                                    <li class="relative z-10">
                                        <div class="flex flex-col items-center">
                                            <div class="flex items-center justify-center w-10 h-10 bg-indigo-600 rounded-full">
                                                <span class="flex items-center justify-center w-8 h-8 bg-indigo-600 rounded-full">
                                                    <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <span class="mt-2 text-sm font-medium text-gray-900">Advanced</span>
                                        </div>
                                    </li>
                                </div>
                            </ol>
                        </nav>
                    </div>

                    <!-- Basic Info Section -->
                    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>

                        <!-- Name Field -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Cluster Name <span class="text-red-500">*</span></label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="name" class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-md @error('name') border-red-500 @enderror" value="{{ old('name', $cluster['name']) }}" placeholder="e.g. Production Cluster">
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
                            @else
                            <p class="mt-1 text-sm text-gray-500">Choose a descriptive name to identify this cluster.</p>
                            @enderror
                        </div>

                        <!-- Endpoint Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">API Endpoint <span class="text-red-500">*</span></label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" name="endpoint" class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-md @error('endpoint') border-red-500 @enderror" value="{{ old('endpoint', $cluster['endpoint']) }}" placeholder="https://172.29.176.1:16443">
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
                            @else
                            <p class="mt-1 text-sm text-gray-500">The URL of your Kubernetes API server.</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Authentication Section -->
                    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Authentication Settings</h3>

                        <!-- Auth Type Field -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Authentication Method <span class="text-red-500">*</span></label>
                            <div class="mt-1 space-y-4">
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="auth-proxy" name="auth_type" type="radio" x-model="authType" value="P" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ old('auth_type', $cluster['auth_type']) == 'P' ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="auth-proxy" class="font-medium text-gray-700">Proxy (No authentication)</label>
                                        <p class="text-gray-500">Use this when connecting through kubectl proxy or similar tools.</p>
                                    </div>
                                </div>
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="auth-token" name="auth_type" type="radio" x-model="authType" value="T" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ old('auth_type', $cluster['auth_type']) == 'T' ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="auth-token" class="font-medium text-gray-700">Token (Bearer authentication)</label>
                                        <p class="text-gray-500">Use a service account token for authentication.</p>
                                    </div>
                                </div>
                            </div>
                            @error('auth_type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Token Field (Conditional) -->
                        <div x-show="authType === 'T'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-5 bg-white p-4 rounded-md border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bearer Token <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <textarea name="token" rows="3" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-md font-mono text-sm @error('token') border-red-500 @enderror" placeholder="Paste your token here">{{ old('token') }}</textarea>
                                @error('token')
                                <div class="absolute top-2 right-2 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                @enderror
                            </div>
                            <div class="mt-2 flex items-center">
                                <svg class="h-5 w-5 text-indigo-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-sm text-gray-500">
                                    For security reasons, the token will be encrypted when stored.
                                </p>
                            </div>
                            @error('token')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Advanced Settings Section -->
                    <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Advanced Settings</h3>
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Optional</span>
                        </div>

                        <!-- Timeout Field -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Connection Timeout (seconds)</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" name="timeout" min="1" max="60" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-md @error('timeout') border-red-500 @enderror" value="{{ old('timeout', $cluster['timeout']) }}" placeholder="5">
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
                            @else
                            <p class="mt-1 text-sm text-gray-500">Maximum time to wait for a response from the API server.</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Documentation Link -->
                    <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-100">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-indigo-800">Need help?</h3>
                                <div class="mt-1 text-sm text-indigo-700">
                                    <p>Check the <a href="https://kubernetes.io/docs/tasks/administer-cluster/access-cluster-api/?amp;amp#without-kubectl-proxy" class="font-medium underline hover:text-indigo-600" target="_blank">Kubernetes API Access documentation</a> for detailed instructions.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-3 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
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
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-900">Delete Cluster</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Permanently remove this cluster configuration
                        </p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <form method="POST" action="{{route ('Clusters.destroy',$cluster['id'])}}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <div class="bg-red-50 p-4 rounded-md border border-red-100 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Warning</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>This action cannot be undone. This will permanently delete the cluster configuration from our servers.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="_delete('Are you sure you want to delete this Cluster?','{{ route("Clusters.destroy", $cluster["id"]) }}')" class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Delete this Cluster
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Alpine.js for conditional fields -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-app-layout>