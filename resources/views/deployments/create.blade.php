<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900">
                Create New Deployment
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Configure a new Kubernetes deployment for your application
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
                        <span class="ml-2 text-sm font-medium text-indigo-600">Containers</span>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-xl font-semibold text-gray-900">Create New Deployment</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Configure a new Kubernetes deployment for your application
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                <form method="POST" action="{{route('Deployments.store')}}" class="space-y-8">
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deployment Name <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <input type="text" name="name" id="name"
                                    class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg @error('name') border-red-500 @enderror"
                                    value="{{ old('name') }}" placeholder="my-deployment">
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
                        <div class="max-w-2xl mb-6">
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
                            <p class="mt-2 text-sm text-gray-500">The namespace where this deployment will be created.</p>
                            @enderror
                        </div>

                        <!-- Replicas Field -->
                        <div class="max-w-2xl">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Replicas <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                                    </svg>
                                </div>
                                <input type="text" name="replicas"
                                    class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg @error('replicas') border-red-500 @enderror"
                                    value="{{ old('replicas') }}" placeholder="3">
                                @error('replicas')
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                @enderror
                            </div>
                            @error('replicas')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @else
                            <p class="mt-2 text-sm text-gray-500">Number of desired pod instances to run.</p>
                            @enderror
                        </div>
                    </div>
                    <!-- Label Matching Section -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 mt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <span class="flex-shrink-0 bg-indigo-100 text-indigo-700 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                    <span class="text-sm font-semibold">2</span>
                                </span>
                                Label Matching <span class="text-red-500">*</span>
                            </h3>
                            <button type="button"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                onClick="appendInput('matchLabels', 'matchLabels[]')">
                                <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Add Label Matching
                            </button>
                        </div>

                        <p class="text-sm text-gray-500 mb-4">Define labels to select which pods this deployment will manage.</p>

                        <div id="matchLabels" class="space-y-3">
                            @error('key_matchLabels')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            @if(old('key_matchLabels') || old('value_matchLabels'))
                            @foreach(old('key_matchLabels') as $index => $key)
                            <div class="flex flex-wrap items-center space-x-2 p-3 bg-white rounded-lg border border-gray-200 shadow-sm dynamic-input">
                                <div class="flex-grow md:flex-grow-0 min-w-[200px] mb-2 md:mb-0">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Key</label>
                                    <input type="text"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error(" key_matchLabels.{$index}") border-red-500 @enderror"
                                        name="key_matchLabels[]"
                                        value="{{ $key }}"
                                        placeholder="app">
                                    @error("key_matchLabels.$index")
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex-grow md:flex-grow-0 min-w-[200px] mb-2 md:mb-0">
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Value</label>
                                    <input type="text"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error(" value_matchLabels.{$index}") border-red-500 @enderror"
                                        name="value_matchLabels[]"
                                        value="{{ old('value_matchLabels')[$index] }}"
                                        placeholder="frontend">
                                    @error("value_matchLabels.$index")
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-end mb-2 md:mb-0">
                                    <button type="button" class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-full transition-colors duration-200 removeInput">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Metadata Section -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <span class="flex-shrink-0 bg-indigo-100 text-indigo-700 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                <span class="text-sm font-semibold">3</span>
                            </span>
                            Metadata
                        </h3>

                        <!-- Include the infoCreation template -->
                        @include("template/resource_creation/infoCreation")
                        <!-- Template Labels Section -->
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 mt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                    <span class="flex-shrink-0 bg-indigo-100 text-indigo-700 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                        <span class="text-sm font-semibold">4</span>
                                    </span>
                                    Template Labels <span class="text-red-500">*</span>
                                </h3>
                                <button type="button"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                    onClick="appendInput('templateLabels', 'templateLabels[]')">
                                    <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Add Template Label
                                </button>
                            </div>

                            <p class="text-sm text-gray-500 mb-4">Define labels that will be applied to pods created by this deployment.</p>

                            <div id="templateLabels" class="space-y-3">
                                @error('key_templateLabels')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                @if(old('key_templateLabels'))
                                @foreach(old('key_templateLabels') as $index => $key)
                                <div class="flex flex-wrap items-center space-x-2 p-3 bg-white rounded-lg border border-gray-200 shadow-sm dynamic-input">
                                    <div class="flex-grow md:flex-grow-0 min-w-[200px] mb-2 md:mb-0">
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Key</label>
                                        <input type="text"
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error(" key_templateLabels.{$index}") border-red-500 @enderror"
                                            name="key_templateLabels[]"
                                            value="{{ $key }}"
                                            placeholder="app">
                                        @error("key_templateLabels.$index")
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex-grow md:flex-grow-0 min-w-[200px] mb-2 md:mb-0">
                                        <label class="block text-xs font-medium text-gray-500 mb-1">Value</label>
                                        <input type="text"
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error(" value_templateLabels.{$index}") border-red-500 @enderror"
                                            name="value_templateLabels[]"
                                            value="{{ old('value_templateLabels')[$index] }}"
                                            placeholder="frontend">
                                        @error("value_templateLabels.$index")
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="flex items-end mb-2 md:mb-0">
                                        <button type="button" class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-full transition-colors duration-200 removeInput">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <!-- Containers Section -->
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 mt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                    <span class="flex-shrink-0 bg-indigo-100 text-indigo-700 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                        <span class="text-sm font-semibold">5</span>
                                    </span>
                                    Containers <span class="text-red-500">*</span>
                                </h3>
                                <button type="button"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                    onClick="appendInput('containers', 'containers[]')">
                                    <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Add Container
                                </button>
                            </div>

                            <p class="text-sm text-gray-500 mb-4">Define the containers that will run in each pod of this deployment.</p>

                            @error('containers')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <div id="containers" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if(old('containers'))
                                <script>
                                    let containerCount = 0;
                                </script>
                                @foreach(old('containers') as $index => $key)
                                <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden dynamic-input">
                                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                                        <h5 class="text-base font-medium text-gray-900">Container #{{$index + 1}}</h5>
                                        <button type="button" class="text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200 removeInput">
                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="p-4 space-y-4">
                                        <!-- Container Name -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Container Name <span class="text-red-500">*</span></label>
                                            <input type="text"
                                                name="containers[{{$index}}][name]"
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error(" containers.$index.name") border-red-500 @enderror"
                                                value="{{ isset($key['name']) ? $key['name'] : ''}}"
                                                placeholder="my-container">
                                            @error("containers.$index.name")
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Container Image -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Container Image <span class="text-red-500">*</span></label>
                                            <input type="text"
                                                name="containers[{{$index}}][image]"
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error(" containers.$index.image") border-red-500 @enderror"
                                                value="{{ isset($key['image']) ? $key['image'] : ''}}"
                                                placeholder="nginx:latest">
                                            @error("containers.$index.image")
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Image Pull Policy -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Image Pull Policy <span class="text-red-500">*</span></label>
                                            <select class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error(" containers.$index.imagePullPolicy") border-red-500 @enderror"
                                                name="containers[{{$index}}][imagePullPolicy]">
                                                <option {{isset($key['imagePullPolicy']) && $key['imagePullPolicy'] == "Always" ? 'selected' : ''}} value="Always">Always</option>
                                                <option {{isset($key['imagePullPolicy']) && $key['imagePullPolicy'] == "IfNotPresent" ? 'selected' : ''}} value="IfNotPresent">IfNotPresent</option>
                                                <option {{isset($key['imagePullPolicy']) && $key['imagePullPolicy'] == "Never" ? 'selected' : ''}} value="Never">Never</option>
                                            </select>
                                            @error("containers.$index.imagePullPolicy")
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Ports -->
                                        <div class="border-t border-gray-200 pt-4">
                                            <div class="flex items-center justify-between mb-3">
                                                <h6 class="text-sm font-medium text-gray-700">Ports</h6>
                                                <button type="button"
                                                    class="inline-flex items-center px-2 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                                    onclick="addPort({{$index}})">
                                                    <svg class="-ml-1 mr-1 h-3 w-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    Add Port
                                                </button>
                                            </div>

                                            <div id="ports-{{$index}}" class="space-y-2">
                                                @if(old("containers.$index.ports"))
                                                @foreach(old("containers.$index.ports") as $indexPort => $keyPort)
                                                <div class="flex items-center space-x-2 dynamic-input">
                                                    <div class="flex-grow">
                                                        <div class="relative rounded-md shadow-sm">
                                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-500 sm:text-sm">Port</span>
                                                            </div>
                                                            <input type="text"
                                                                class="pl-14 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error(" containers.$index.ports.$indexPort") border-red-500 @enderror"
                                                                name="containers[{{$index}}][ports][{{$indexPort}}]"
                                                                value="{{ isset($keyPort) ? $keyPort : ''}}"
                                                                placeholder="80">
                                                        </div>
                                                        @error("containers.$index.ports.$indexPort")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <button type="button" class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-full transition-colors duration-200 removeInput">
                                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Environment Variables -->
                                        <div class="border-t border-gray-200 pt-4">
                                            <div class="flex items-center justify-between mb-3">
                                                <h6 class="text-sm font-medium text-gray-700">Environment Variables</h6>
                                                <button type="button"
                                                    class="inline-flex items-center px-2 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                                    onclick="addEnv({{$index}})">
                                                    <svg class="-ml-1 mr-1 h-3 w-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    Add Env Var
                                                </button>
                                            </div>

                                            <div id="env-{{$index}}" class="space-y-3">
                                                @if(old("containers.$index.env.key") && old("containers.$index.env.value"))
                                                @foreach(old("containers.$index.env.key") as $indexEnv => $keyEnv)
                                                <div class="flex flex-wrap items-center space-x-2 dynamic-input">
                                                    <div class="flex-grow md:flex-grow-0 min-w-[120px] mb-2 md:mb-0">
                                                        <label class="block text-xs font-medium text-gray-500 mb-1">Key</label>
                                                        <input type="text"
                                                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error(" containers.$index.env.key.$indexEnv") border-red-500 @enderror"
                                                            name="containers[{{$index}}][env][key][{{$indexEnv}}]"
                                                            value="{{ old("containers.$index.env.key.$indexEnv") }}"
                                                            placeholder="KEY_NAME">
                                                        @error("containers.$index.env.key.$indexEnv")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div class="flex-grow md:flex-grow-0 min-w-[120px] mb-2 md:mb-0">
                                                        <label class="block text-xs font-medium text-gray-500 mb-1">Value</label>
                                                        <input type="text"
                                                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error(" containers.$index.env.value.$indexEnv") border-red-500 @enderror"
                                                            name="containers[{{$index}}][env][value][{{$indexEnv}}]"
                                                            value="{{ old("containers.$index.env.value.$indexEnv") }}"
                                                            placeholder="value">
                                                        @error("containers.$index.env.value.$indexEnv")
                                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                                        @enderror
                                                    </div>

                                                    <div class="flex items-end mb-2 md:mb-0">
                                                        <button type="button" class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-full transition-colors duration-200 removeInput">
                                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    containerCount = {
                                        {
                                            $index
                                        }
                                    };
                                </script>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <!-- Advanced Settings Section -->
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200 mt-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                    <span class="flex-shrink-0 bg-indigo-100 text-indigo-700 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                        <span class="text-sm font-semibold">6</span>
                                    </span>
                                    Advanced Settings
                                </h3>
                            </div>

                            <p class="text-sm text-gray-500 mb-6">Configure additional deployment settings for fine-grained control.</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Update Strategy -->
                                <div>
                                    <label for="strategy" class="block text-sm font-medium text-gray-700 mb-1">Update Strategy Type</label>
                                    <select id="strategy"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('strategy') border-red-500 @enderror"
                                        name="strategy"
                                        onchange="handleStrategyChange()">
                                        <option {{old('strategy') == "Auto" ? 'selected' : ''}} value="Auto">Auto</option>
                                        <option {{old('strategy') == "RollingUpdate" ? 'selected' : ''}} value="RollingUpdate">RollingUpdate</option>
                                        <option {{old('strategy') == "Recreate" ? 'selected' : ''}} value="Recreate">Recreate</option>
                                    </select>
                                    @error('strategy')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @else
                                    <p class="mt-1 text-sm text-gray-500">How pods should be replaced when updating the deployment.</p>
                                    @enderror
                                </div>

                                <!-- Minimum Ready Time -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Ready Time (seconds)</label>
                                    <input type="text"
                                        name="minReadySeconds"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('minReadySeconds') border-red-500 @enderror"
                                        value="{{old('minReadySeconds')}}"
                                        placeholder="30">
                                    @error('minReadySeconds')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @else
                                    <p class="mt-1 text-sm text-gray-500">Time a pod must be ready before being considered available.</p>
                                    @enderror
                                </div>

                                <!-- Strategy Parameters (conditional) -->
                                <div id="strategyParameters" class="md:col-span-2">
                                    @if (old('strategy') == 'RollingUpdate')
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                        <div>
                                            <label for="maxUnavailable" class="block text-sm font-medium text-gray-700 mb-1">Max Unavailable <span class="text-red-500">*</span></label>
                                            <input type="text"
                                                id="maxUnavailable"
                                                name="maxUnavailable"
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('maxUnavailable') border-red-500 @enderror"
                                                placeholder="1"
                                                value="{{old('maxUnavailable')}}">
                                            @error('maxUnavailable')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @else
                                            <p class="mt-1 text-sm text-gray-500">Maximum number of pods that can be unavailable during update.</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="maxSurge" class="block text-sm font-medium text-gray-700 mb-1">Max Surge <span class="text-red-500">*</span></label>
                                            <input type="text"
                                                id="maxSurge"
                                                name="maxSurge"
                                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('maxSurge') border-red-500 @enderror"
                                                placeholder="1"
                                                value="{{old('maxSurge')}}">
                                            @error('maxSurge')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @else
                                            <p class="mt-1 text-sm text-gray-500">Maximum number of pods that can be created over desired number.</p>
                                            @enderror
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Revision History Limit -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Revision History Limit</label>
                                    <input type="text"
                                        name="revisionHistoryLimit"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('revisionHistoryLimit') border-red-500 @enderror"
                                        value="{{old('revisionHistoryLimit')}}"
                                        placeholder="5">
                                    @error('revisionHistoryLimit')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @else
                                    <p class="mt-1 text-sm text-gray-500">Number of old ReplicaSets to retain for rollback.</p>
                                    @enderror
                                </div>

                                <!-- Progress Deadline -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Progress Deadline (seconds)</label>
                                    <input type="text"
                                        name="progressDeadlineSeconds"
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('progressDeadlineSeconds') border-red-500 @enderror"
                                        value="{{old('progressDeadlineSeconds')}}"
                                        placeholder="600">
                                    @error('progressDeadlineSeconds')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @else
                                    <p class="mt-1 text-sm text-gray-500">Maximum time for deployment to make progress before it is considered failed.</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end mt-8">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                                Create Deployment
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include the deployment creation script -->
    @include("template/resource_creation/createDeployment")

    <!-- Additional script to handle the new UI elements -->
    <script>
        // Update the appendInput function to work with the new UI
        function appendInput(baseDivName, inputName) {
            const baseDiv = document.getElementById(baseDivName);

            if (baseDivName === 'matchLabels') {
                const baseInput = document.createElement('div');
                baseInput.classList.add('flex', 'flex-wrap', 'items-center', 'space-x-2', 'p-3', 'bg-white', 'rounded-lg', 'border', 'border-gray-200', 'shadow-sm', 'dynamic-input');

                baseInput.innerHTML = `
                    <div class="flex-grow md:flex-grow-0 min-w-[200px] mb-2 md:mb-0">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Key</label>
                        <input type="text" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                            name="key_${inputName}" 
                            placeholder="app">
                    </div>
                    
                    <div class="flex-grow md:flex-grow-0 min-w-[200px] mb-2 md:mb-0">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Value</label>
                        <input type="text" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                            name="value_${inputName}" 
                            placeholder="frontend">
                    </div>
                    
                    <div class="flex items-end mb-2 md:mb-0">
                        <button type="button" class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-full transition-colors duration-200 removeInput">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                `;

                baseDiv.appendChild(baseInput);
                return;
            }

            if (baseDivName === 'templateLabels') {
                const baseInput = document.createElement('div');
                baseInput.classList.add('flex', 'flex-wrap', 'items-center', 'space-x-2', 'p-3', 'bg-white', 'rounded-lg', 'border', 'border-gray-200', 'shadow-sm', 'dynamic-input');

                baseInput.innerHTML = `
                    <div class="flex-grow md:flex-grow-0 min-w-[200px] mb-2 md:mb-0">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Key</label>
                        <input type="text" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                            name="key_${inputName}" 
                            placeholder="app">
                    </div>
                    
                    <div class="flex-grow md:flex-grow-0 min-w-[200px] mb-2 md:mb-0">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Value</label>
                        <input type="text" 
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                            name="value_${inputName}" 
                            placeholder="frontend">
                    </div>
                    
                    <div class="flex items-end mb-2 md:mb-0">
                        <button type="button" class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-full transition-colors duration-200 removeInput">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                `;

                baseDiv.appendChild(baseInput);
                return;
            }

            if (baseDivName === 'containers') {
                const baseInput = document.createElement('div');
                baseInput.classList.add('bg-white', 'rounded-lg', 'border', 'border-gray-200', 'shadow-sm', 'overflow-hidden', 'dynamic-input');
                containerCount++;

                baseInput.innerHTML = `
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                        <h5 class="text-base font-medium text-gray-900">Container #${containerCount + 1}</h5>
                        <button type="button" class="text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200 removeInput">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-4 space-y-4">
                        <!-- Container Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Container Name <span class="text-red-500">*</span></label>
                            <input type="text" 
                                   name="containers[${containerCount}][name]" 
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                   placeholder="my-container">
                        </div>
                        
                        <!-- Container Image -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Container Image <span class="text-red-500">*</span></label>
                            <input type="text" 
                                   name="containers[${containerCount}][image]" 
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                   placeholder="nginx:latest">
                        </div>
                        
                        <!-- Image Pull Policy -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Image Pull Policy <span class="text-red-500">*</span></label>
                            <select class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                    name="containers[${containerCount}][imagePullPolicy]">
                                <option value="Always">Always</option> 
                                <option value="IfNotPresent">IfNotPresent</option> 
                                <option value="Never">Never</option> 
                            </select>
                        </div>
                        
                        <!-- Ports -->
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between mb-3">
                                <h6 class="text-sm font-medium text-gray-700">Ports</h6>
                                <button type="button" 
                                        class="inline-flex items-center px-2 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                        onclick="addPort(${containerCount})">
                                    <svg class="-ml-1 mr-1 h-3 w-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Add Port
                                </button>
                            </div>
                            
                            <div id="ports-${containerCount}" class="space-y-2">
                            </div>
                        </div>
                        
                        <!-- Environment Variables -->
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between mb-3">
                                <h6 class="text-sm font-medium text-gray-700">Environment Variables</h6>
                                <button type="button" 
                                        class="inline-flex items-center px-2 py-1 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                        onclick="addEnv(${containerCount})">
                                    <svg class="-ml-1 mr-1 h-3 w-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Add Env Var
                                </button>
                            </div>
                            
                            <div id="env-${containerCount}" class="space-y-3">
                            </div>
                        </div>
                    </div>
                `;

                baseDiv.appendChild(baseInput);
                return;
            }
        }

        // Override the addPort function to match the new UI
        function addPort(containerId) {
            const portDiv = document.createElement('div');
            portDiv.classList.add('flex', 'items-center', 'space-x-2', 'dynamic-input');

            portDiv.innerHTML = `
                <div class="flex-grow">
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Port</span>
                        </div>
                        <input type="text" 
                               class="pl-14 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                               name="containers[${containerId}][ports][]" 
                               placeholder="80">
                    </div>
                </div>
                
                <button type="button" class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-full transition-colors duration-200 removeInput">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;

            document.getElementById(`ports-${containerId}`).appendChild(portDiv);
        }

        // Override the addEnv function to match the new UI
        function addEnv(containerId) {
            const envDiv = document.createElement('div');
            envDiv.classList.add('flex', 'flex-wrap', 'items-center', 'space-x-2', 'dynamic-input');

            envDiv.innerHTML = `
                <div class="flex-grow md:flex-grow-0 min-w-[120px] mb-2 md:mb-0">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Key</label>
                    <input type="text" 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                           name="containers[${containerId}][env][key][]" 
                           placeholder="KEY_NAME">
                </div>
                
                <div class="flex-grow md:flex-grow-0 min-w-[120px] mb-2 md:mb-0">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Value</label>
                    <input type="text" 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                           name="containers[${containerId}][env][value][]" 
                           placeholder="value">
                </div>
                
                <div class="flex items-end mb-2 md:mb-0">
                    <button type="button" class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-full transition-colors duration-200 removeInput">
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            `;

            document.getElementById(`env-${containerId}`).appendChild(envDiv);
        }
    </script>
</x-app-layout>