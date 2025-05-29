<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900">
                Create a New Namespace
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Configure a new Kubernetes namespace
            </p>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <nav class="flex items-center space-x-4 sm:space-x-8" aria-label="Progress">
                    <div class="flex items-center">
                        <span class="relative flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-white">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="sr-only">Step 1</span>
                        </span>
                        <span class="ml-2 text-sm font-medium text-indigo-600">Basic Info</span>
                    </div>
                    
                    <div class="hidden md:flex md:items-center">
                        <div class="h-0.5 w-12 bg-indigo-600"></div>
                    </div>
                    
                    <div class="flex items-center">
                        <span class="relative flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-white">
                            <span>2</span>
                            <span class="sr-only">Step 2</span>
                        </span>
                        <span class="ml-2 text-sm font-medium text-indigo-600">Metadata</span>
                    </div>
                    
                    <div class="hidden md:flex md:items-center">
                        <div class="h-0.5 w-12 bg-indigo-600"></div>
                    </div>
                    
                    <div class="flex items-center">
                        <span class="relative flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-white">
                            <span>3</span>
                            <span class="sr-only">Step 3</span>
                        </span>
                        <span class="ml-2 text-sm font-medium text-indigo-600">Finalizers</span>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-2">
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-900">Create New Namespace</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Configure a new isolated environment in your Kubernetes cluster
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                <form method="POST" action="{{ route('Namespaces.store') }}" class="space-y-8">
                    @csrf
                    
                    <!-- Basic Information Section -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <span class="flex-shrink-0 bg-indigo-100 text-indigo-700 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                <span class="text-sm font-semibold">1</span>
                            </span>
                            Basic Information
                        </h3>
                        
                        <!-- Name Field -->
                        <div class="max-w-2xl">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Namespace Name <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <input type="text" name="name" 
                                       class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg @error('name') border-red-500 @enderror" 
                                       value="{{ old('name') }}" placeholder="my-namespace">
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
                            <p class="mt-2 text-sm text-gray-500">The name must be unique within the cluster and follow DNS naming conventions.</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Metadata Section -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <span class="flex-shrink-0 bg-indigo-100 text-indigo-700 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                <span class="text-sm font-semibold">2</span>
                            </span>
                            Metadata
                        </h3>
                        
                        <!-- Include the infoCreation template -->
                        @include("template/resource_creation/infoCreation")
                    </div>

                    <!-- Finalizers Section -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <span class="flex-shrink-0 bg-indigo-100 text-indigo-700 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                <span class="text-sm font-semibold">3</span>
                            </span>
                            Finalizers
                        </h3>
                        
                        <div class="mb-4">
                            <p class="text-sm text-gray-500">Finalizers allow controllers to implement asynchronous pre-delete hooks.</p>
                        </div>
                        
                        <div id="finalizers" class="space-y-3">
                            <button type="button" 
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                    onClick="appendInput('finalizers','finalizers[]')">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Add Finalizer
                            </button>
                            
                            @if (old('finalizers'))
                                @foreach (old('finalizers') as $index => $finalizer)
                                <div class="flex items-center space-x-2 bg-white p-3 rounded-lg border border-gray-200 shadow-sm">
                                    <div class="flex-1">
                                        <input type="text" 
                                               class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-2 border border-gray-300 rounded-lg @error("finalizers.{$index}") border-red-500 @enderror" 
                                               name="finalizers[]" 
                                               value="{{ $finalizer }}">
                                        @error("finalizers.{$index}")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('Namespaces.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to Namespaces
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Create Namespace
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Help Card -->
        <div class="mt-8 bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <div class="px-6 py-4 bg-indigo-50 border-b border-indigo-100">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="ml-2 text-lg font-medium text-indigo-900">About Kubernetes Namespaces</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="prose max-w-none">
                    <p>Namespaces provide a mechanism for isolating groups of resources within a single cluster. Names of resources need to be unique within a namespace, but not across namespaces.</p>
                    <h4>Common Use Cases:</h4>
                    <ul>
                        <li>Dividing cluster resources between multiple users or teams</li>
                        <li>Limiting resource consumption with quotas per namespace</li>
                        <li>Separating development, staging, and production environments</li>
                        <li>Organizing applications and their dependencies</li>
                    </ul>
                    <p class="text-sm text-gray-500 mt-4">For more information, refer to the <a href="https://kubernetes.io/docs/concepts/overview/working-with-objects/namespaces/" class="text-indigo-600 hover:text-indigo-900" target="_blank">Kubernetes documentation</a>.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to append new finalizer input
        function appendInput(containerId, name) {
            const container = document.getElementById(containerId);
            const newInput = document.createElement('div');
            newInput.className = 'flex items-center space-x-2 bg-white p-3 rounded-lg border border-gray-200 shadow-sm';
            newInput.innerHTML = `
                <div class="flex-1">
                    <input type="text" 
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-2 border border-gray-300 rounded-lg" 
                           name="${name}" placeholder="kubernetes.io/example-finalizer">
                </div>
                <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;
            container.appendChild(newInput);
        }

        // Event delegation for remove buttons
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeInput') || e.target.closest('.removeInput')) {
                const button = e.target.classList.contains('removeInput') ? e.target : e.target.closest('.removeInput');
                button.closest('.flex.items-center').remove();
            }
        });
    </script>
</x-app-layout>