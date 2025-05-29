<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900">
                Create New Ingress
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Configure a new Kubernetes ingress for your application
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
                        <span class="ml-2 text-sm font-medium text-indigo-600">Rules</span>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-900">Create New Ingress</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Configure routing rules for external access to your services
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                <form method="POST" action="{{ route('Ingresses.store') }}" class="space-y-8">
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ingress Name <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                    </svg>
                                </div>
                                <input type="text" name="name" 
                                       class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg @error('name') border-red-500 @enderror" 
                                       value="{{ old('name') }}" placeholder="my-ingress">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
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
                            <p class="mt-2 text-sm text-gray-500">The namespace where this ingress will be created.</p>
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

                    <!-- Rules Section -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <span class="flex-shrink-0 bg-indigo-100 text-indigo-700 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                <span class="text-sm font-semibold">3</span>
                            </span>
                            Routing Rules
                        </h3>
                        
                        <div class="mb-4">
                            <p class="text-sm text-gray-500">Define how traffic should be routed to your services.</p>
                        </div>
                        
                        <!-- Rules -->
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <h4 class="text-base font-medium text-gray-900">Rules</h4>
                                    <p class="text-sm text-gray-500 mt-1">Configure host and path-based routing</p>
                                </div>
                                <button type="button" 
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                        onClick="appendRule()">
                                    <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Add Rule
                                </button>
                            </div>
                            @error('rules')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Rules Dynamic Container -->
                        <div id="rules" class="space-y-4">
                            @if(old('rules'))
                            <script>
                                let ruleCount = 0;
                            </script>
                            @foreach(old('rules') as $index => $key)
                            <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm" data-index="{{ $index }}">
                                <div class="flex justify-between items-center mb-3">
                                    <h5 class="text-base font-medium text-gray-900">Rule #{{ $index + 1 }}</h5>
                                    <button type="button" class="text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200" onclick="removeRule(this)">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Host name -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Host</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <input type="text" 
                                               name="rules[{{ $index }}][host]" 
                                               class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-2 border border-gray-300 rounded-lg @error('rules.' . $index . '.host') border-red-500 @enderror" 
                                               value="{{ old('rules.'.$index.'.host') }}" 
                                               placeholder="example.com">
                                        @error('rules.'.$index.'.host')
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        @enderror
                                    </div>
                                    @error('rules.'.$index.'.host')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @else
                                    <p class="mt-1 text-sm text-gray-500">The hostname that this rule applies to.</p>
                                    @enderror
                                </div>

                                <!-- Paths -->
                                <div class="mb-3">
                                    <div class="flex items-center justify-between mb-3">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Paths</h4>
                                            <p class="text-xs text-gray-500 mt-1">Define URL paths and their target services</p>
                                        </div>
                                        <button type="button" 
                                                class="inline-flex items-center px-2 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                                onclick="addPath({{ $index }})">
                                            <svg class="-ml-1 mr-1 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                            Add Path
                                        </button>
                                    </div>
                                    @error('rules.'.$index.'.path')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    
                                    <div id="paths-{{ $index }}" class="space-y-3">
                                        @if(old("rules.$index.path.pathName"))
                                        @foreach(old("rules.$index.path.pathName") as $indexPath => $pathName)
                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-start bg-gray-50 p-3 rounded-lg border border-gray-200">
                                            <!-- Path Name -->
                                            <div class="md:col-span-3">
                                                <label class="block text-xs font-medium text-gray-700 mb-1">Path</label>
                                                <input type="text" 
                                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error('rules.'.$index.'.path.pathName.'.$indexPath) border-red-500 @enderror" 
                                                       name="rules[{{ $index }}][path][pathName][{{ $indexPath }}]" 
                                                       value="{{ $pathName }}" 
                                                       placeholder="/api">
                                                @error('rules.'.$index.'.path.pathName.'.$indexPath)
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <!-- Path Type -->
                                            <div class="md:col-span-2">
                                                <label class="block text-xs font-medium text-gray-700 mb-1">Type</label>
                                                <select name="rules[{{ $index }}][path][pathType][{{ $indexPath }}]" 
                                                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error('rules.'.$index.'.path.pathType.'.$indexPath) border-red-500 @enderror">
                                                    <option value="Prefix" {{ old('rules.'.$index.'.path.pathType.'.$indexPath) == 'Prefix' ? 'selected' : '' }}>Prefix</option>
                                                    <option value="Exact" {{ old('rules.'.$index.'.path.pathType.'.$indexPath) == 'Exact' ? 'selected' : '' }}>Exact</option>
                                                    <option value="ImplementationSpecific" {{ old('rules.'.$index.'.path.pathType.'.$indexPath) == 'ImplementationSpecific' ? 'selected' : '' }}>Implementation Specific</option>
                                                </select>
                                                @error('rules.'.$index.'.path.pathType.'.$indexPath)
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <!-- Service Name -->
                                            <div class="md:col-span-8">
                                                <label class="block text-xs font-medium text-gray-700 mb-1">Service</label>
                                                <input type="text" 
                                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error('rules.'.$index.'.path.serviceName.'.$indexPath) border-red-500 @enderror" 
                                                       name="rules[{{ $index }}][path][serviceName][{{ $indexPath }}]" 
                                                       value="{{ old('rules.'.$index.'.path.serviceName.'.$indexPath) }}" 
                                                       placeholder="my-service">
                                                @error('rules.'.$index.'.path.serviceName.'.$indexPath)
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <!-- Port -->
                                            <div class="md:col-span-2">
                                                <label class="block text-xs font-medium text-gray-700 mb-1">Port</label>
                                                <input type="text" 
                                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md @error('rules.'.$index.'.path.portNumber.'.$indexPath) border-red-500 @enderror" 
                                                       name="rules[{{ $index }}][path][portNumber][{{ $indexPath }}]" 
                                                       value="{{ old('rules.'.$index.'.path.portNumber.'.$indexPath) }}" 
                                                       placeholder="80">
                                                @error('rules.'.$index.'.path.portNumber.'.$indexPath)
                                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="md:col-span-1 flex justify-center pt-6">
                                                <button type="button" class="text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200" onclick="removePath(this)">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="text-center py-4 text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-200 border-dashed">
                                            <p>No paths added yet</p>
                                            <p class="mt-1">Click "Add Path" to define URL paths and target services</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <script>
                                ruleCount = {{ $index }};
                            </script>
                            @endforeach
                            @else
                            <div class="text-center py-6 text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-200 border-dashed">
                                <p>No rules added yet</p>
                                <p class="mt-1">Click "Add Rule" to define routing rules for your ingress</p>
                            </div>
                            @endif
                        </div>

                        <!-- Default Backend -->
                        <div class="mt-6">
                            <h4 class="text-base font-medium text-gray-900 mb-3">Default Backend (Optional)</h4>
                            <p class="text-sm text-gray-500 mb-4">Service to handle requests that don't match any rule</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                <!-- Service Name -->
                                <div class="md:col-span-8">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Name</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                                            </svg>
                                        </div>
                                        <input type="text" 
                                               name="defaultBackendName" 
                                               class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-2 border border-gray-300 rounded-lg @error('defaultBackendName') border-red-500 @enderror" 
                                               value="{{ old('defaultBackendName') }}" 
                                               placeholder="default-service">
                                    </div>
                                    @error('defaultBackendName')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Port -->
                                <div class="md:col-span-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Port</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <input type="text" 
                                               name="defaultBackendPort" 
                                               class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-2 border border-gray-300 rounded-lg @error('defaultBackendPort') border-red-500 @enderror" 
                                               value="{{ old('defaultBackendPort') }}" 
                                               placeholder="80">
                                    </div>
                                    @error('defaultBackendPort')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('Ingresses.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to Ingresses
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Create Ingress
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
                    <h3 class="ml-2 text-lg font-medium text-indigo-900">About Kubernetes Ingresses</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="prose max-w-none">
                    <p>An Ingress is a Kubernetes resource that manages external access to services in a cluster, typically HTTP. Ingress can provide load balancing, SSL termination and name-based virtual hosting.</p>
                    <h4>Key Components:</h4>
                    <ul>
                        <li><strong>Rules</strong>: Define how traffic is routed based on host and path</li>
                        <li><strong>Paths</strong>: URL paths that map to specific services</li>
                        <li><strong>Backend</strong>: The service that handles a request</li>
                        <li><strong>Default Backend</strong>: Handles requests that don't match any rules</li>
                    </ul>
                    <p class="text-sm text-gray-500 mt-4">For more information, refer to the <a href="https://kubernetes.io/docs/concepts/services-networking/ingress/" class="text-indigo-600 hover:text-indigo-900" target="_blank">Kubernetes documentation</a>.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts for dynamic functionality -->
    <script>
        // Initialize rule counter
        let ruleCount = {{ old('rules') ? count(old('rules')) - 1 : -1 }};
        
        // Function to append a new rule
        function appendRule() {
            ruleCount++;
            const rulesContainer = document.getElementById('rules');
            
            // Remove empty state message if it exists
            const emptyState = rulesContainer.querySelector('.text-center.py-6');
            if (emptyState) {
                emptyState.remove();
            }
            
            const newRule = document.createElement('div');
            newRule.className = 'bg-white rounded-lg p-4 border border-gray-200 shadow-sm';
            newRule.setAttribute('data-index', ruleCount);
            
            newRule.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <h5 class="text-base font-medium text-gray-900">Rule #${ruleCount + 1}</h5>
                    <button type="button" class="text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200" onclick="removeRule(this)">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                
                <!-- Host name -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Host</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <input type="text" 
                               name="rules[${ruleCount}][host]" 
                               class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-2 border border-gray-300 rounded-lg" 
                               placeholder="example.com">
                    </div>
                    <p class="mt-1 text-sm text-gray-500">The hostname that this rule applies to.</p>
                </div>

                <!-- Paths -->
                <div class="mb-3">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">Paths</h4>
                            <p class="text-xs text-gray-500 mt-1">Define URL paths and their target services</p>
                        </div>
                        <button type="button" 
                                class="inline-flex items-center px-2 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                onclick="addPath(${ruleCount})">
                            <svg class="-ml-1 mr-1 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add Path
                        </button>
                    </div>
                    
                    <div id="paths-${ruleCount}" class="space-y-3">
                        <div class="text-center py-4 text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-200 border-dashed">
                            <p>No paths added yet</p>
                            <p class="mt-1">Click "Add Path" to define URL paths and target services</p>
                        </div>
                    </div>
                </div>
            `;
            
            rulesContainer.appendChild(newRule);
        }

        // Function to remove a rule
        function removeRule(btn) {
            const ruleElement = btn.closest('[data-index]');
            const rulesContainer = ruleElement.parentElement;
            
            ruleElement.remove();
            
            // If there are no more rules, add the empty state message back
            if (rulesContainer.children.length === 0) {
                const emptyState = document.createElement('div');
                emptyState.className = 'text-center py-6 text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-200 border-dashed';
                emptyState.innerHTML = `
                    <p>No rules added yet</p>
                    <p class="mt-1">Click "Add Rule" to define routing rules for your ingress</p>
                `;
                rulesContainer.appendChild(emptyState);
            }
        }

        // Function to add a path to a specific rule
        function addPath(ruleIndex) {
            const pathsContainer = document.getElementById(`paths-${ruleIndex}`);
            
            // Remove empty state message if it exists
            const emptyState = pathsContainer.querySelector('.text-center.py-4');
            if (emptyState) {
                emptyState.remove();
            }
            
            // Get the current path count for this rule
            const pathCount = pathsContainer.children.length;
            
            const newPath = document.createElement('div');
            newPath.className = 'grid grid-cols-1 md:grid-cols-12 gap-3 items-start bg-gray-50 p-3 rounded-lg border border-gray-200';
            
            newPath.innerHTML = `
                <!-- Path Name -->
                <div class="md:col-span-3">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Path</label>
                    <input type="text" 
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md" 
                           name="rules[${ruleIndex}][path][pathName][${pathCount}]" 
                           placeholder="/api">
                </div>
                
                <!-- Path Type -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Type</label>
                    <select name="rules[${ruleIndex}][path][pathType][${pathCount}]" 
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="Prefix">Prefix</option>
                        <option value="Exact">Exact</option>
                        <option value="ImplementationSpecific">Implementation Specific</option>
                    </select>
                </div>
                
                <!-- Service Name -->
                <div class="md:col-span-4">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Service</label>
                    <input type="text" 
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md" 
                           name="rules[${ruleIndex}][path][serviceName][${pathCount}]" 
                           placeholder="my-service">
                </div>
                
                <!-- Port -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Port</label>
                    <input type="text" 
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-2 border border-gray-300 rounded-md" 
                           name="rules[${ruleIndex}][path][portNumber][${pathCount}]" 
                           placeholder="80">
                </div>
                
                <div class="md:col-span-1 flex justify-center pt-6">
                    <button type="button" class="text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200" onclick="removePath(this)">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            `;
            
            pathsContainer.appendChild(newPath);
        }

        // Function to remove a path
        function removePath(btn) {
            const pathElement = btn.closest('.grid');
            const pathsContainer = pathElement.parentElement;
            
            pathElement.remove();
            
            // If there are no more paths, add the empty state message back
            if (pathsContainer.children.length === 0) {
                const emptyState = document.createElement('div');
                emptyState.className = 'text-center py-4 text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-200 border-dashed';
                emptyState.innerHTML = `
                    <p>No paths added yet</p>
                    <p class="mt-1">Click "Add Path" to define URL paths and target services</p>
                `;
                pathsContainer.appendChild(emptyState);
            }
        }
    </script>
</x-app-layout>