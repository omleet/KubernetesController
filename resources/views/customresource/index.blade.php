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
                            <div class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                                <h3 class="text-sm font-medium mb-2">Error:</h3>
                                <p class="text-sm">{{ session('error_msg')['message'] ?? 'An unknown error occurred' }}</p>
                                @if(isset(session('error_msg')['status']) && isset(session('error_msg')['code']))
                                <p class="text-xs mt-1 text-red-500">{{ session('error_msg')['status'] }} ({{ session('error_msg')['code'] }})</p>
                                @endif
                            </div>
                            @endif

                            @if(session('success-msg'))
                            <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                                <p class="text-sm">{{ session('success-msg') }}</p>
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
        // Function to pretty print JSON
        function prettyPrint() {
            const textarea = document.getElementById('resource');
            try {
                const jsonData = JSON.parse(textarea.value);
                textarea.value = JSON.stringify(jsonData, null, 2);
            } catch (e) {
                showNotification('Invalid JSON: ' + e.message, 'error');
            }
        }

        // Function to reset the form
        function resetForm() {
            const textarea = document.getElementById('resource');
            textarea.value = '';
            loadTemplate('pod');
            showNotification('Form has been reset', 'info');
        }

        // Function to show notification
        function showNotification(message, type) {
            // You can implement a toast notification here
            // For now, we'll use alert
            if (type === 'error') {
                alert('Error: ' + message);
            } else {
                alert(message);
            }
        }

        // Function to load template
        function loadTemplate(type) {
            const textarea = document.getElementById('resource');

            let template = '';

            if (type === 'pod') {
                template = `{
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
}`;
            } else if (type === 'deployment') {
                template = `{
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
}`;
            } else if (type === 'service') {
                template = `{
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
}`;
            } else if (type === 'ingress') {
                template = `{
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
}`;
            } else if (type === 'namespace') {
                template = `{
    "apiVersion": "v1",
    "kind": "Namespace",
    "metadata": {
        "name": "example-namespace"
    }
}`;
            }

            textarea.value = template;
            prettyPrint();
        }

        // Initialize with example JSON if empty
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('resource');
            if (!textarea.value.trim()) {
                loadTemplate('pod');
            }

            // Prevent double form submission
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');

            if (form && submitBtn) {
                form.addEventListener('submit', function(e) {
                    // Validate JSON before submission
                    try {
                        const jsonContent = textarea.value.trim();
                        if (!jsonContent) {
                            e.preventDefault();
                            alert('Please enter a valid JSON resource definition.');
                            return;
                        }

                        // Try to parse the JSON to validate it
                        JSON.parse(jsonContent);

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
                        alert('Invalid JSON format: ' + error.message);
                    }
                });
            }
        });
    </script>
</x-app-layout>