<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900">
                Create a New Service
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Configure a new Kubernetes service
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
                        <span class="ml-2 text-sm font-medium text-indigo-600">Ports & Selectors</span>
                    </div>

                    <div class="hidden md:flex md:items-center">
                        <div class="h-0.5 w-12 bg-indigo-600"></div>
                    </div>
                    
                    <div class="flex items-center">
                        <span class="relative flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-white">
                            <span>4</span>
                            <span class="sr-only">Step 4</span>
                        </span>
                        <span class="ml-2 text-sm font-medium text-indigo-600">Settings</span>
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
                        <h2 class="text-xl font-semibold text-gray-900">Create New Service</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Configure a new service in your Kubernetes cluster
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                <form method="POST" action="{{ route('Services.store') }}" class="space-y-8">
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
                        <div class="max-w-2xl mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Service Name <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <input type="text" name="name" 
                                       class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg @error('name') border-red-500 @enderror" 
                                       value="{{ old('name') }}" placeholder="my-service">
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
                            <p class="mt-2 text-sm text-gray-500">The name must be unique within the namespace and follow DNS naming conventions.</p>
                            @enderror
                        </div>
                        
                        <!-- Namespace Field -->
                        <div class="max-w-2xl">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Namespace <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                </div>
                                <input type="text" name="namespace" 
                                       class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg @error('namespace') border-red-500 @enderror" 
                                       value="{{ old('namespace') }}" placeholder="default">
                                @error('namespace')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                @enderror
                            </div>
                            @error('namespace')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @else
                            <p class="mt-2 text-sm text-gray-500">The namespace where this service will be created. Must exist in the cluster.</p>
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

                    <!-- Ports & Selectors Section -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <span class="flex-shrink-0 bg-indigo-100 text-indigo-700 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                <span class="text-sm font-semibold">3</span>
                            </span>
                            Ports & Selectors
                        </h3>
                        
                        <!-- Selector Labels -->
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Selector Labels</h4>
                            <p class="text-sm text-gray-500 mb-4">Define labels to select which pods this service will target.</p>
                            
                            <button type="button" 
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                    onClick="appendInput('selectorLabels', 'selectorLabels[]')">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Add Selector Label
                            </button>
                            
                            <div class="mt-4 space-y-3" id="selectorLabels">
                                @if(old('key_selectorLabels'))
                                    @foreach(old('key_selectorLabels') as $index => $key)
                                        <div class="flex items-center space-x-2 bg-white p-3 rounded-lg border border-gray-200 shadow-sm dynamic-input">
                                            <div class="flex-1 grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Key</label>
                                                    <input type="text" 
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error("key_selectorLabels.{$index}") border-red-500 @enderror" 
                                                           name="key_selectorLabels[]" 
                                                           value="{{ $key }}">
                                                    @error("key_selectorLabels.{$index}")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Value</label>
                                                    <input type="text" 
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error("value_selectorLabels.{$index}") border-red-500 @enderror" 
                                                           name="value_selectorLabels[]" 
                                                           value="{{ old('value_selectorLabels')[$index] }}">
                                                    @error("value_selectorLabels.{$index}")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        
                        <!-- Ports -->
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Ports <span class="text-red-500">*</span></h4>
                            <p class="text-sm text-gray-500 mb-4">Define the ports that this service will expose.</p>
                            
                            <button type="button" 
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                    onClick="appendInput('ports', 'ports[]')">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Add Port
                            </button>
                            
                            <div class="mt-4 space-y-4" id="ports">
                                @if(old('portName'))
                                    @foreach(old('portName') as $index => $name)
                                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm dynamic-input">
                                            <div class="flex items-center justify-between mb-3">
                                                <h5 class="text-sm font-medium text-gray-700">Port Configuration</h5>
                                                <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Name</label>
                                                    <input type="text" 
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error("portName.{$index}") border-red-500 @enderror" 
                                                           name="portName[]" 
                                                           value="{{ $name }}">
                                                    @error("portName.{$index}")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Protocol</label>
                                                    <select class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error("protocol.{$index}") border-red-500 @enderror" 
                                                            name="protocol[]">
                                                        <option value="TCP" {{ old('protocol')[$index] == 'TCP' ? 'selected' : '' }}>TCP</option> 
                                                        <option value="UDP" {{ old('protocol')[$index] == 'UDP' ? 'selected' : '' }}>UDP</option> 
                                                    </select>
                                                    @error("protocol.{$index}")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Port</label>
                                                    <input type="text" 
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error("port.{$index}") border-red-500 @enderror" 
                                                           name="port[]" 
                                                           value="{{ old('port')[$index] }}">
                                                    @error("port.{$index}")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Target Port</label>
                                                    <input type="text" 
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error("target.{$index}") border-red-500 @enderror" 
                                                           name="target[]" 
                                                           value="{{ old('target')[$index] }}">
                                                    @error("target.{$index}")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Node Port (optional)</label>
                                                    <input type="text" 
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error("nodePort.{$index}") border-red-500 @enderror" 
                                                           name="nodePort[]" 
                                                           value="{{ old('nodePort')[$index] }}">
                                                    @error("nodePort.{$index}")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        
                        <!-- Ports -->
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Ports</h4>
                            <p class="text-sm text-gray-500 mb-4">Define the ports that this service will expose.</p>
                            
                            <button type="button" 
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                    onClick="appendInput('ports', 'ports[]')">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Add Port
                            </button>
                            
                            <div class="mt-4 space-y-4" id="ports">
                                @if (old('protocol'))
                                    @foreach (old('protocol') as $index => $portData)
                                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm dynamic-input">
                                            <div class="flex items-center justify-between mb-3">
                                                <h5 class="text-sm font-medium text-gray-700">Port Configuration</h5>
                                                <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Name</label>
                                                    <input type="text" 
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error("portName.$index") border-red-500 @enderror" 
                                                           name="portName[]" 
                                                           value="{{ old("portName.$index") }}">
                                                    @error("portName.$index")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Protocol</label>
                                                    <select class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error("protocol.$index") border-red-500 @enderror" 
                                                            name="protocol[]">
                                                        <option value="TCP" {{ $portData == "TCP" ? 'selected' : '' }}>TCP</option> 
                                                        <option value="UDP" {{ $portData == "UDP" ? 'selected' : '' }}>UDP</option> 
                                                    </select>
                                                    @error("protocol.$index")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Port</label>
                                                    <input type="text" 
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error("port.$index") border-red-500 @enderror" 
                                                           name="port[]" 
                                                           value="{{ old("port.$index") }}">
                                                    @error("port.$index")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Target Port</label>
                                                    <input type="text" 
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error("target.$index") border-red-500 @enderror" 
                                                           name="target[]" 
                                                           value="{{ old("target.$index") }}">
                                                    @error("target.$index")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-xs font-medium text-gray-500 mb-1">Node Port (optional)</label>
                                                    <input type="text" 
                                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error("nodePort.$index") border-red-500 @enderror" 
                                                           name="nodePort[]" 
                                                           value="{{ old("nodePort.$index") }}">
                                                    @error("nodePort.$index")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Settings Section -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <span class="flex-shrink-0 bg-indigo-100 text-indigo-700 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                <span class="text-sm font-semibold">4</span>
                            </span>
                            Service Settings
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Service Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Service Type <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <select class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg" 
                                            name="type" 
                                            id="type" 
                                            onchange="handleChange('type')">
                                        <option value="Auto" {{old('type') == "Auto" ? 'selected' : ''}}>Auto</option> 
                                        <option value="ClusterIP" {{old('type') == "ClusterIP" ? 'selected' : ''}}>ClusterIP</option> 
                                        <option value="NodePort" {{old('type') == "NodePort" ? 'selected' : ''}}>NodePort</option> 
                                        <option value="LoadBalancer" {{old('type') == "LoadBalancer" ? 'selected' : ''}}>LoadBalancer</option> 
                                        <option value="ExternalName" {{old('type') == "ExternalName" ? 'selected' : ''}}>ExternalName</option> 
                                    </select>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">The type determines how the service is exposed.</p>
                            </div>
                            
                            <!-- External Traffic Policy -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">External Traffic Policy <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <select class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg" 
                                            name="externalTrafficPolicy">
                                        <option value="Auto" {{old('externalTrafficPolicy') == "Auto" ? 'selected' : ''}}>Auto</option> 
                                        <option value="Cluster" {{old('externalTrafficPolicy') == "Cluster" ? 'selected' : ''}}>Cluster</option> 
                                        <option value="Local" {{old('externalTrafficPolicy') == "Local" ? 'selected' : ''}}>Local</option> 
                                    </select>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Determines how external traffic is routed.</p>
                            </div>
                            
                            <!-- Session Affinity -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Session Affinity <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <select class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg" 
                                            name="sessionAffinity" 
                                            id="sessionAffinity" 
                                            onchange="handleChange('sessionAffinity')">
                                        <option value="Auto" {{old('sessionAffinity') == "Auto" ? 'selected' : ''}}>Auto</option> 
                                        <option value="None" {{old('sessionAffinity') == "None" ? 'selected' : ''}}>None</option> 
                                        <option value="ClientIP" {{old('sessionAffinity') == "ClientIP" ? 'selected' : ''}}>ClientIP</option> 
                                    </select>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Determines if client requests go to the same pod.</p>
                            </div>
                            
                            <!-- External Name (conditional) -->
                            <div id="typeParameter">
                                @if (old('type') == 'ExternalName')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">External Name <span class="text-red-500">*</span></label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="text" 
                                               name="externalName" 
                                               class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg @error('externalName') border-red-500 @enderror" 
                                               placeholder="my-name.domain.test" 
                                               value="{{ old('externalName') }}">
                                        @error('externalName')
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('externalName')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @else
                                    <p class="mt-2 text-sm text-gray-500">The external domain name to map to this service.</p>
                                    @enderror
                                </div>
                                @endif
                            </div>
                            
                            <!-- Session Affinity Timeout (conditional) -->
                            <div id="sessionAffinityParameter">
                                @if (old('sessionAffinityTimeoutSeconds'))
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Session Affinity Timeout</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="text" 
                                               name="sessionAffinityTimeoutSeconds" 
                                               class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg @error('sessionAffinityTimeoutSeconds') border-red-500 @enderror" 
                                               placeholder="10800" 
                                               value="{{ old('sessionAffinityTimeoutSeconds') }}">
                                        @error('sessionAffinityTimeoutSeconds')
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('sessionAffinityTimeoutSeconds')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @else
                                    <p class="mt-2 text-sm text-gray-500">Timeout in seconds for session affinity.</p>
                                    @enderror
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Settings Section -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <span class="flex-shrink-0 bg-indigo-100 text-indigo-700 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                <span class="text-sm font-semibold">4</span>
                            </span>
                            Settings
                        </h3>
                        
                        <!-- Service Type -->
                        <div class="max-w-2xl mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Service Type <span class="text-red-500">*</span></label>
                            <select id="type" 
                                    name="type" 
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg @error('type') border-red-500 @enderror"
                                    onchange="handleChange('type')">
                                <option value="Auto" {{ old('type') == 'Auto' ? 'selected' : '' }}>Auto (ClusterIP)</option>
                                <option value="ClusterIP" {{ old('type') == 'ClusterIP' ? 'selected' : '' }}>ClusterIP</option>
                                <option value="NodePort" {{ old('type') == 'NodePort' ? 'selected' : '' }}>NodePort</option>
                                <option value="LoadBalancer" {{ old('type') == 'LoadBalancer' ? 'selected' : '' }}>LoadBalancer</option>
                                <option value="ExternalName" {{ old('type') == 'ExternalName' ? 'selected' : '' }}>ExternalName</option>
                            </select>
                            @error('type')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @else
                            <p class="mt-2 text-sm text-gray-500">The type of service to create.</p>
                            @enderror
                            
                            <!-- Conditional field for ExternalName -->
                            <div id="typeParameter" class="mt-4">
                                @if(old('type') == 'ExternalName')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">External Name <span class="text-red-500">*</span></label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="text" 
                                               name="externalName" 
                                               class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg @error('externalName') border-red-500 @enderror" 
                                               placeholder="my-name.domain.test" 
                                               value="{{ old('externalName') }}">
                                        @error('externalName')
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('externalName')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @else
                                    <p class="mt-2 text-sm text-gray-500">The external domain name to map to this service.</p>
                                    @enderror
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- External Traffic Policy -->
                        <div class="max-w-2xl mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">External Traffic Policy <span class="text-red-500">*</span></label>
                            <select name="externalTrafficPolicy" 
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg @error('externalTrafficPolicy') border-red-500 @enderror">
                                <option value="Auto" {{ old('externalTrafficPolicy') == 'Auto' ? 'selected' : '' }}>Auto</option>
                                <option value="Cluster" {{ old('externalTrafficPolicy') == 'Cluster' ? 'selected' : '' }}>Cluster</option>
                                <option value="Local" {{ old('externalTrafficPolicy') == 'Local' ? 'selected' : '' }}>Local</option>
                            </select>
                            @error('externalTrafficPolicy')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @else
                            <p class="mt-2 text-sm text-gray-500">Denotes if this Service desires to route external traffic to node-local or cluster-wide endpoints.</p>
                            @enderror
                        </div>
                        
                        <!-- Session Affinity -->
                        <div class="max-w-2xl mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Session Affinity <span class="text-red-500">*</span></label>
                            <select id="sessionAffinity" 
                                    name="sessionAffinity" 
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg @error('sessionAffinity') border-red-500 @enderror"
                                    onchange="handleChange('sessionAffinity')">
                                <option value="Auto" {{ old('sessionAffinity') == 'Auto' ? 'selected' : '' }}>Auto (None)</option>
                                <option value="None" {{ old('sessionAffinity') == 'None' ? 'selected' : '' }}>None</option>
                                <option value="ClientIP" {{ old('sessionAffinity') == 'ClientIP' ? 'selected' : '' }}>ClientIP</option>
                            </select>
                            @error('sessionAffinity')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @else
                            <p class="mt-2 text-sm text-gray-500">Specifies the session affinity for this service.</p>
                            @enderror
                            
                            <!-- Conditional field for ClientIP -->
                            <div id="sessionAffinityParameter" class="mt-4">
                                @if(old('sessionAffinity') == 'ClientIP')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Session Affinity Timeout</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="text" 
                                               name="sessionAffinityTimeoutSeconds" 
                                               class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg @error('sessionAffinityTimeoutSeconds') border-red-500 @enderror" 
                                               placeholder="10800" 
                                               value="{{ old('sessionAffinityTimeoutSeconds') }}">
                                        @error('sessionAffinityTimeoutSeconds')
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('sessionAffinityTimeoutSeconds')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @else
                                    <p class="mt-2 text-sm text-gray-500">Timeout in seconds for session affinity.</p>
                                    @enderror
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" id="submitBtn" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Create Service
                        </button>
                    </div>
                    
                    <!-- Form validation error message -->
                    @if($errors->any())
                    <div class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <h3 class="text-sm font-medium mb-2">Please fix the following errors:</h3>
                        <ul class="list-disc pl-5 space-y-1 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    
    <script>
        // Function to handle conditional fields
        function handleChange(field) {
            if (field === 'type') {
                const typeValue = document.getElementById('type').value;
                const typeParameterDiv = document.getElementById('typeParameter');
                
                if (typeValue === 'ExternalName') {
                    typeParameterDiv.innerHTML = `
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">External Name <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" 
                                       name="externalName" 
                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg" 
                                       placeholder="my-name.domain.test" 
                                       value="">
                            </div>
                            <p class="mt-2 text-sm text-gray-500">The external domain name to map to this service.</p>
                        </div>
                    `;
                } else {
                    typeParameterDiv.innerHTML = '';
                }
            }
            
            if (field === 'sessionAffinity') {
                const affinityValue = document.getElementById('sessionAffinity').value;
                const affinityParameterDiv = document.getElementById('sessionAffinityParameter');
                
                if (affinityValue === 'ClientIP') {
                    affinityParameterDiv.innerHTML = `
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Session Affinity Timeout</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" 
                                       name="sessionAffinityTimeoutSeconds" 
                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg" 
                                       placeholder="10800" 
                                       value="">
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Timeout in seconds for session affinity.</p>
                        </div>
                    `;
                } else {
                    affinityParameterDiv.innerHTML = '';
                }
            }
        }
        
        // Function to append dynamic inputs
        function appendInput(containerId, inputName) {
            const container = document.getElementById(containerId);
            
            if (containerId === 'selectorLabels') {
                const newLabel = document.createElement('div');
                newLabel.className = 'flex items-center space-x-2 bg-white p-3 rounded-lg border border-gray-200 shadow-sm dynamic-input';
                newLabel.innerHTML = `
                    <div class="flex-1 grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Key</label>
                            <input type="text" 
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md" 
                                   name="key_selectorLabels[]" 
                                   value="">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Value</label>
                            <input type="text" 
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md" 
                                   name="value_selectorLabels[]" 
                                   value="">
                        </div>
                    </div>
                    <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                `;
                container.appendChild(newLabel);
            }
            
            if (containerId === 'ports') {
                const newPort = document.createElement('div');
                newPort.className = 'bg-white p-4 rounded-lg border border-gray-200 shadow-sm dynamic-input';
                newPort.innerHTML = `
                    <div class="flex items-center justify-between mb-3">
                        <h5 class="text-sm font-medium text-gray-700">Port Configuration</h5>
                        <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Name</label>
                            <input type="text" 
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md" 
                                   name="portName[]" 
                                   value="">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Protocol</label>
                            <select class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md" 
                                    name="protocol[]">
                                <option value="TCP">TCP</option> 
                                <option value="UDP">UDP</option> 
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Port</label>
                            <input type="text" 
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md" 
                                   name="port[]" 
                                   value="">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Target Port</label>
                            <input type="text" 
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md" 
                                   name="target[]" 
                                   value="">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Node Port (optional)</label>
                            <input type="text" 
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md" 
                                   name="nodePort[]" 
                                   value="">
                        </div>
                    </div>
                `;
                container.appendChild(newPort);
            }
        }
        
        // Event delegation for remove buttons
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeInput') || e.target.closest('.removeInput')) {
                const button = e.target.classList.contains('removeInput') ? e.target : e.target.closest('.removeInput');
                const parent = button.closest('.dynamic-input');
                if (parent) {
                    parent.remove();
                }
            }
        });

        // Add a default port configuration when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Add at least one port configuration by default
            if (!document.querySelector('#ports .dynamic-input')) {
                appendInput('ports', 'ports[]');
                
                // Set default values for the port fields
                const portNameInput = document.querySelector('input[name="portName[]"]');
                if (portNameInput) portNameInput.value = 'http';
                
                const portInput = document.querySelector('input[name="port[]"]');
                if (portInput) portInput.value = '80';
                
                const targetInput = document.querySelector('input[name="target[]"]');
                if (targetInput) targetInput.value = '80';
                
                const nodePortInput = document.querySelector('input[name="nodePort[]"]');
                if (nodePortInput) nodePortInput.value = '30000';
            }
            
            // Add at least one selector label by default
            if (!document.querySelector('#selectorLabels .dynamic-input')) {
                appendInput('selectorLabels', 'selectorLabels[]');
                
                // Set default values for the selector label fields
                const keyInput = document.querySelector('input[name="key_selectorLabels[]"]');
                if (keyInput) keyInput.value = 'app';
                
                const valueInput = document.querySelector('input[name="value_selectorLabels[]"]');
                if (valueInput) valueInput.value = 'my-app';
            }
            
            // Prevent double form submission
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');
            
            if (form && submitBtn) {
                form.addEventListener('submit', function(e) {
                    // Prevent the default form submission
                    e.preventDefault();
                    
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
                    
                    // Submit the form after a short delay
                    setTimeout(function() {
                        form.submit();
                    }, 100);
                });
            }
        });
    </script>
    
</x-app-layout>