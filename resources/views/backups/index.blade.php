<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900">
                Export your Data
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Configure your Data to Export
            </p>
        </div>
    </x-slot>

    <div class="w-full max-w-5xl mx-auto p-6">
        <div class="mb-8">
            <div class="bg-gradient-to-r from-indigo-700 to-purple-700 rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-8 md:px-10 md:py-10 text-white">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold">Export your Data</h2>
                            <p class="mt-2 text-indigo-100"> Select the Data that you want to Export</p>
                        </div>
                        <div class="mt-4 md:mt-0 flex space-x-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <!-- Form content -->
            <div class="p-8">
                <form id="backupForm" method="POST" action="{{route('Backups.store')}}">
                    @csrf
                    
                    <!-- Resources Section -->
                    <div class="mb-10">
                        <div class="flex items-center mb-6">
                            <div class="bg-indigo-100 p-2 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-800">Resources to Include</h4>
                        </div>
                        
                        <div id="resourcesContainer" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="flex items-center p-4 bg-white rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-200">
                                <input id="namespaces" type="checkbox" class="resource-checkbox form-checkbox h-5 w-5 text-indigo-600 rounded-md focus:ring-indigo-500" name="namespaces" value="true">
                                <label for="namespaces" class="ml-3 flex flex-col">
                                    <span class="font-medium text-gray-800">Namespaces</span>
                                    <span class="text-xs text-gray-500 mt-1">Logical partitions of your cluster</span>
                                </label>
                            </div>
                            
                            <div class="flex items-center p-4 bg-white rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-200">
                                <input id="pods" type="checkbox" class="resource-checkbox form-checkbox h-5 w-5 text-indigo-600 rounded-md focus:ring-indigo-500" name="pods" value="true">
                                <label for="pods" class="ml-3 flex flex-col">
                                    <span class="font-medium text-gray-800">Pods</span>
                                    <span class="text-xs text-gray-500 mt-1">Individual containers and their configurations</span>
                                </label>
                            </div>
                            
                            <div class="flex items-center p-4 bg-white rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-200">
                                <input id="deployments" type="checkbox" class="resource-checkbox form-checkbox h-5 w-5 text-indigo-600 rounded-md focus:ring-indigo-500" name="deployments" value="true">
                                <label for="deployments" class="ml-3 flex flex-col">
                                    <span class="font-medium text-gray-800">Deployments</span>
                                    <span class="text-xs text-gray-500 mt-1">Deployment configurations and replicas</span>
                                </label>
                            </div>
                            
                            <div class="flex items-center p-4 bg-white rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-200">
                                <input id="services" type="checkbox" class="resource-checkbox form-checkbox h-5 w-5 text-indigo-600 rounded-md focus:ring-indigo-500" name="services" value="true">
                                <label for="services" class="ml-3 flex flex-col">
                                    <span class="font-medium text-gray-800">Services</span>
                                    <span class="text-xs text-gray-500 mt-1">Network configurations and endpoints</span>
                                </label>
                            </div>
                            
                            <div class="flex items-center p-4 bg-white rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-200">
                                <input id="ingresses" type="checkbox" class="resource-checkbox form-checkbox h-5 w-5 text-indigo-600 rounded-md focus:ring-indigo-500" name="ingresses" value="true">
                                <label for="ingresses" class="ml-3 flex flex-col">
                                    <span class="font-medium text-gray-800">Ingresses</span>
                                    <span class="text-xs text-gray-500 mt-1">External access rules and routing</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Validation message -->
                        <div id="resourceValidationMessage" class="hidden mt-4 text-red-500 text-sm font-medium">
                            Please select at least one resource to include in the backup.
                        </div>
                    </div>
                    
                    <!-- Options Section -->
                    <div class="mb-10 pt-8">
                        <div class="flex items-center mb-6">
                            <div class="bg-indigo-100 p-2 rounded-lg mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-800">Advanced Options</h4>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-start p-4 bg-white rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-200">
                                <div class="flex items-center h-5 mt-1">
                                    <input id="excludeDefaultResources" type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600 rounded-md focus:ring-indigo-500" name="excludeDefaultResources" value="true">
                                </div>
                                <label for="excludeDefaultResources" class="ml-3 flex flex-col">
                                    <span class="font-medium text-gray-800">Exclude default resources</span>
                                    <p class="text-sm text-gray-500 mt-1">System resources will not be included in the backup. This helps reduce backup size and focuses only on your application resources.</p>
                                </label>
                            </div>
                            
                            <div class="flex items-start p-4 bg-white rounded-lg border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-200">
                                <div class="flex items-center h-5 mt-1">
                                    <input id="excludeDeploymentPods" type="checkbox" class="form-checkbox h-5 w-5 text-indigo-600 rounded-md focus:ring-indigo-500" name="excludeDeploymentPods" value="true">
                                </div>
                                <label for="excludeDeploymentPods" class="ml-3 flex flex-col">
                                    <span class="font-medium text-gray-800">Exclude deployment Pods</span>
                                    <p class="text-sm text-gray-500 mt-1">Only applies when Pod backups are selected. Pods managed by deployments will be excluded as they can be recreated from deployment configurations.</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex justify-end pt-6 border-t border-gray-100">
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                            Cancel
                        </button>
                        <button id="submitButton" type="button" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Create Backup
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('backupForm');
            const submitButton = document.getElementById('submitButton');
            const resourceCheckboxes = document.querySelectorAll('.resource-checkbox');
            const validationMessage = document.getElementById('resourceValidationMessage');
            
            // Function to check if at least one resource is selected
            function isAtLeastOneResourceSelected() {
                return Array.from(resourceCheckboxes).some(checkbox => checkbox.checked);
            }
            
            // Function to validate form before submission
            function validateForm() {
                if (isAtLeastOneResourceSelected()) {
                    validationMessage.classList.add('hidden');
                    form.submit();
                } else {
                    validationMessage.classList.remove('hidden');
                    // Scroll to the validation message
                    validationMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
            
            // Add event listener to submit button
            submitButton.addEventListener('click', validateForm);
            
            // Add event listeners to checkboxes to hide validation message when a checkbox is checked
            resourceCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (isAtLeastOneResourceSelected()) {
                        validationMessage.classList.add('hidden');
                    }
                });
            });
        });
    </script>
</x-app-layout>