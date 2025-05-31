<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Create Resource using JSON
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Advanced tool for creating custom Kubernetes resources
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-indigo-700 to-purple-700 rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-8 md:px-10 md:py-10 text-white">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold">Custom Resource Editor</h2>
                            <p class="mt-2 text-indigo-100">Create and deploy any Kubernetes resource using JSON</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-900 bg-opacity-50 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                                For Advanced Users
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Editor Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">JSON Editor</h3>
                            <p class="text-sm text-gray-500">
                                Enter your Kubernetes resource definition
                            </p>
                        </div>
                        <div class="bg-indigo-50 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                    </div>

                    <div class="p-6">
                        <form method="POST" action="{{ route('CustomResources.store') }}" class="space-y-6">
                            @csrf

                            <!-- JSON Editor -->
                            <div>
                                <div class="relative">
                                    <div class="absolute top-0 right-0 mt-2 mr-6 flex space-x-2">
                                        <button type="button" onclick="prettyPrint()" class="inline-flex items-center px-2 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded hover:bg-indigo-200 focus:outline-none transition-colors duration-150">
                                            <svg class="h-3.5 w-3.5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                            </svg>
                                            Format the code
                                        </button>
                                    </div>
                                    <textarea name="resource" id="resource" rows="20"
                                        class="font-mono text-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-200 rounded-lg shadow-inner bg-gray-50 @error('resource') border-red-500 @enderror"
                                        placeholder='{
  "apiVersion": "v1",
  "kind": "Pod",
  "metadata": {
    "name": "example-pod"
  },
  "spec": {
    "containers": [
      {
        "name": "nginx",
        "image": "nginx:1.14.2",
        "ports": [
          {
            "containerPort": 80
          }
        ]
      }
    ]
  }
}'>{{ old('resource') }}</textarea>
                                    @error('resource')
                                    <div class="absolute inset-y-0 right-0 pr-3 pt-3 flex items-start pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    @enderror
                                </div>
                                @error('resource')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                                <button type="button" onclick="resetForm()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Reset
                                </button>
                                <button type="submit" id="submitBtn" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Create Resource
                                </button>
                            </div>

                            <script>
                                function prettyPrint() {
                                    const textarea = document.getElementById('resource');
                                    try {
                                        const jsonText = textarea.value.trim();
                                        if (jsonText) {
                                            const json = JSON.parse(jsonText);
                                            textarea.value = JSON.stringify(json, null, 2);
                                        }
                                    } catch (e) {
                                        // If JSON is invalid, show an error message
                                        alert('Invalid JSON format: ' + e.message);
                                    }
                                }

                                function resetForm() {
                                    document.getElementById('resource').value = '';
                                    loadTemplate('pod');
                                }
                            </script>

                            <!-- Error message display -->
                            @if(session('error_msg'))
                            <div class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg" role="alert">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Error:</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p>{{ session('error_msg')['message'] ?? 'An unknown error occurred' }}</p>
                                        </div>
                                        @if(isset(session('error_msg')['status']) && isset(session('error_msg')['code']))
                                        <p class="text-xs mt-1 text-red-500">{{ session('error_msg')['status'] }} ({{ session('error_msg')['code'] }})</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(session('success-msg'))
                            <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg" role="alert">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800">Success:</p>
                                        <p class="mt-1 text-sm text-green-700">{{ session('success-msg') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- Help & Templates Section -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Documentation Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Documentation</h3>
                        </div>
                        <div class="bg-blue-50 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">
                            Check the official Kubernetes API documentation for resource specifications and parameters.
                        </p>
                        <a href="https://kubernetes.io/docs/reference/generated/kubernetes-api/v1.26/" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150 w-full justify-center">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            Kubernetes API Docs
                        </a>
                    </div>
                </div>

                <!-- Templates Card -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                    <div class="border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Resource Templates</h3>
                        </div>
                        <div class="bg-green-50 rounded-full p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">
                            Click on a template to load it into the editor:
                        </p>
                        <div class="space-y-3">
                            <button type="button" onclick="loadTemplate('pod')" class="w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-150">
                                <div class="flex items-center">
                                    <div class="bg-green-100 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Pod</div>
                                        <div class="text-xs text-gray-500">Basic pod with a single container</div>
                                    </div>
                                </div>
                            </button>

                            <button type="button" onclick="loadTemplate('namespace')" class="w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-150">
                                <div class="flex items-center">
                                    <div class="bg-green-100 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Namespace</div>
                                        <div class="text-xs text-gray-500">Basic namespace</div>
                                    </div>
                                </div>
                            </button>

                            <button type="button" onclick="loadTemplate('ingress')" class="w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-150">
                                <div class="flex items-center">
                                    <div class="bg-green-100 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Ingress</div>
                                        <div class="text-xs text-gray-500">Basic ingress</div>
                                    </div>
                                </div>
                            </button>



                            <button type="button" onclick="loadTemplate('deployment')" class="w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-150">
                                <div class="flex items-center">
                                    <div class="bg-green-100 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Deployment</div>
                                        <div class="text-xs text-gray-500">Deployment with replica management</div>
                                    </div>
                                </div>
                            </button>

                            <button type="button" onclick="loadTemplate('service')" class="w-full text-left px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-150">
                                <div class="flex items-center">
                                    <div class="bg-green-100 rounded-full p-2 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Service</div>
                                        <div class="text-xs text-gray-500">Service to expose pods</div>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        /**
         * Pretty print the JSON in the textarea
         */
        function prettyPrint() {
            const textarea = document.getElementById('resource');
            try {
                const jsonData = JSON.parse(textarea.value);
                textarea.value = JSON.stringify(jsonData, null, 2);
                showToast('JSON formatted successfully', 'success');
            } catch (e) {
                showToast('Invalid JSON: ' + e.message, 'error');
            }
        }

        /**
         * Reset the form and load a template
         */
        function resetForm() {
            const textarea = document.getElementById('resource');
            textarea.value = '';
            loadTemplate('pod');
            showToast('Form has been reset', 'info');
        }

        /**
         * Show a toast notification
         * 
         * @param {string} message - The message to display
         * @param {string} type - The type of notification (success, error, info)
         */
        function showToast(message, type) {
            // Create toast container if it doesn't exist
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'fixed bottom-4 right-4 z-50 flex flex-col space-y-2';
                document.body.appendChild(toastContainer);
            }
            
            // Create toast element
            const toast = document.createElement('div');
            
            // Set appropriate styles based on type
            let bgColor, textColor, icon;
            switch (type) {
                case 'success':
                    bgColor = 'bg-green-50 border-green-200';
                    textColor = 'text-green-800';
                    icon = '<svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>';
                    break;
                case 'error':
                    bgColor = 'bg-red-50 border-red-200';
                    textColor = 'text-red-800';
                    icon = '<svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>';
                    break;
                default: // info
                    bgColor = 'bg-blue-50 border-blue-200';
                    textColor = 'text-blue-800';
                    icon = '<svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>';
            }
            
            toast.className = `${bgColor} border rounded-lg shadow-md p-4 mb-3 flex items-center transform transition-all duration-300 ease-in-out translate-x-full opacity-0`;
            toast.innerHTML = `
                <div class="flex-shrink-0 mr-3">
                    ${icon}
                </div>
                <div class="${textColor} text-sm font-medium">${message}</div>
                <button class="ml-auto -mx-1.5 -my-1.5 ${textColor} rounded-lg p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" type="button" aria-label="Close" onclick="this.parentElement.remove()">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            `;
            
            // Add to container
            toastContainer.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
            }, 10);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                toast.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 5000);
        }

        // Templates for different Kubernetes resources
        const templates = {
            pod: `{
  "apiVersion": "v1",
  "kind": "Pod",
  "metadata": {
    "name": "example-pod",
    "namespace": "default",
    "labels": {
      "app": "example"
    }
  },
  "spec": {
    "containers": [
      {
        "name": "nginx",
        "image": "nginx:1.14.2",
        "ports": [
          {
            "containerPort": 80
          }
        ],
        "resources": {
          "limits": {
            "cpu": "500m",
            "memory": "128Mi"
          },
          "requests": {
            "cpu": "200m",
            "memory": "64Mi"
          }
        }
      }
    ]
  }
}`,
            deployment: `{
  "apiVersion": "apps/v1",
  "kind": "Deployment",
  "metadata": {
    "name": "example-deployment",
    "labels": {
      "app": "example"
    },
    "namespace": "default"
  },
  "spec": {
    "replicas": 3,
    "selector": {
      "matchLabels": {
        "app": "example"
      }
    },
    "template": {
      "metadata": {
        "labels": {
          "app": "example"
        }
      },
      "spec": {
        "containers": [
          {
            "name": "nginx",
            "image": "nginx:1.14.2",
            "ports": [
              {
                "containerPort": 80
              }
            ]
          }
        ]
      }
    }
  }
}`,
            service: `{
  "apiVersion": "v1",
  "kind": "Service",
  "metadata": {
    "name": "example-service",
    "namespace": "default"
  },
  "spec": {
    "selector": {
      "app": "example"
    },
    "ports": [
      {
        "port": 80,
        "targetPort": 80
      }
    ],
    "type": "ClusterIP"
  }
}`,
            ingress: `{
  "apiVersion": "networking.k8s.io/v1",
  "kind": "Ingress",
  "metadata": {
    "name": "example-ingress",
    "namespace": "default"
  },
  "spec": {
    "ingressClassName": "public",
    "rules": [
      {
        "http": {
          "paths": [
            {
              "path": "/api",
              "pathType": "Prefix",
              "backend": {
                "service": {
                  "name": "my-service",
                  "port": {
                    "number": 80
                  }
                }
              }
            }
          ]
        }
      }
    ]
  }
}`,
            namespace: `{
  "apiVersion": "v1",
  "kind": "Namespace",
  "metadata": {
    "name": "example-namespace"
  }
}`
        };

        /**
         * Load a template into the editor
         * 
         * @param {string} type - The type of template to load
         */
        function loadTemplate(type) {
            const textarea = document.getElementById('resource');
            
            if (templates[type]) {
                textarea.value = templates[type];
                prettyPrint();
                showToast(`${type.charAt(0).toUpperCase() + type.slice(1)} template loaded`, 'info');
            } else {
                showToast(`Template for ${type} not found`, 'error');
            }
        }

        /**
         * Initialize the page
         */
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('resource');
            
            // Add syntax highlighting and auto-indentation (optional enhancement)
            textarea.addEventListener('keydown', function(e) {
                // Auto-indent when pressing Enter
                if (e.key === 'Enter') {
                    e.preventDefault();
                    
                    const cursorPos = this.selectionStart;
                    const textBeforeCursor = this.value.substring(0, cursorPos);
                    const textAfterCursor = this.value.substring(cursorPos);
                    
                    // Get the indentation of the current line
                    const currentLine = textBeforeCursor.split('\n').pop();
                    const indentation = currentLine.match(/^\s*/)[0];
                    
                    // Add extra indentation if the line ends with { or [
                    const extraIndent = /[{[]$/.test(currentLine.trim()) ? '  ' : '';
                    
                    // Insert newline with proper indentation
                    this.value = textBeforeCursor + '\n' + indentation + extraIndent + textAfterCursor;
                    this.selectionStart = this.selectionEnd = cursorPos + 1 + indentation.length + extraIndent.length;
                }
                
                // Auto-close brackets and quotes
                const pairs = {
                    '{': '}',
                    '[': ']',
                    '"': '"'
                };
                
                if (pairs[e.key]) {
                    const cursorPos = this.selectionStart;
                    const selectedText = this.value.substring(this.selectionStart, this.selectionEnd);
                    
                    if (selectedText) {
                        // Wrap selected text with the pair
                        e.preventDefault();
                        const newText = e.key + selectedText + pairs[e.key];
                        const textBeforeCursor = this.value.substring(0, this.selectionStart);
                        const textAfterCursor = this.value.substring(this.selectionEnd);
                        
                        this.value = textBeforeCursor + newText + textAfterCursor;
                        this.selectionStart = cursorPos + 1;
                        this.selectionEnd = cursorPos + 1 + selectedText.length;
                    }
                }
            });
            
            // Load default template if textarea is empty
            if (!textarea.value.trim()) {
                loadTemplate('pod');
            }

            // Form submission handling
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');

            if (form && submitBtn) {
                form.addEventListener('submit', function(e) {
                    // Validate JSON before submission
                    try {
                        const jsonContent = textarea.value.trim();
                        if (!jsonContent) {
                            e.preventDefault();
                            showToast('Please enter a valid JSON resource definition.', 'error');
                            return;
                        }

                        // Try to parse the JSON to validate it
                        const parsedJson = JSON.parse(jsonContent);
                        
                        // Additional validation
                        if (!parsedJson.kind) {
                            e.preventDefault();
                            showToast('Resource must have a "kind" field.', 'error');
                            return;
                        }
                        
                        if (!parsedJson.apiVersion) {
                            e.preventDefault();
                            showToast('Resource must have an "apiVersion" field.', 'error');
                            return;
                        }
                        
                        if (!parsedJson.metadata || !parsedJson.metadata.name) {
                            e.preventDefault();
                            showToast('Resource must have a metadata.name field.', 'error');
                            return;
                        }

                        // Disable the submit button to prevent double submission
                        submitBtn.disabled = true;
                        submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                        submitBtn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Creating...
                        `;
                    } catch (error) {
                        e.preventDefault();
                        showToast('Invalid JSON format: ' + error.message, 'error');
                    }
                });
            }
        });
    </script>
</x-app-layout>