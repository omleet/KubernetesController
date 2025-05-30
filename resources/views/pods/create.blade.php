<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900">
                Create a New Pod
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Configure a new Kubernetes pod
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
                        <h2 class="text-xl font-semibold text-gray-900">Create New Pod</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Configure a new pod in your Kubernetes cluster
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                <form method="POST" action="{{ route('Pods.store') }}" class="space-y-8">
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pod Name <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <input type="text" name="name"
                                    class="pl-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-3 border border-gray-300 rounded-lg @error('name') border-red-500 @enderror"
                                    value="{{ old('name') }}" placeholder="my-pod">
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
                            <p class="mt-2 text-sm text-gray-500">The namespace where this pod will be created. Must exist in the cluster.</p>
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

                    <!-- Containers Section -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <span class="flex-shrink-0 bg-indigo-100 text-indigo-700 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                <span class="text-sm font-semibold">3</span>
                            </span>
                            Containers
                        </h3>

                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-4">Define one or more containers that will run in this pod.</p>

                            <button type="button"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                onClick="appendInput('containers', 'containers[]')">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Add Container
                            </button>

                            @error('containers')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-6" id="containers">
                            @if(old('containers'))
                            <script>
                                let containerCount = 0;
                            </script>
                            @foreach(old('containers') as $index => $key)
                            <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm dynamic-input">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-medium text-gray-900 flex items-center">
                                        <svg class="h-5 w-5 text-indigo-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        Container #{{$index}}
                                    </h4>
                                    <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Container Basic Info -->
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-700 mb-3">Basic Information</h5>

                                        <!-- Container Name -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Container Name <span class="text-red-500">*</span></label>
                                            <input type="text"
                                                name="containers[{{$index}}][name]"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-2 border border-gray-300 rounded-lg @error(" containers.$index.name") border-red-500 @enderror"
                                                value="{{ $key['name'] ?? '' }}"
                                                placeholder="my-container">
                                            @error("containers.$index.name")
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Container Image -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Container Image <span class="text-red-500">*</span></label>
                                            <input type="text"
                                                name="containers[{{$index}}][image]"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-2 border border-gray-300 rounded-lg @error(" containers.$index.image") border-red-500 @enderror"
                                                value="{{ $key['image'] ?? '' }}"
                                                placeholder="nginx:latest">
                                            @error("containers.$index.image")
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Image Pull Policy -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Image Pull Policy <span class="text-red-500">*</span></label>
                                            <select name="containers[{{$index}}][imagePullPolicy]"
                                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-2 border border-gray-300 rounded-lg @error(" containers.$index.imagePullPolicy") border-red-500 @enderror">
                                                <option {{ $key['imagePullPolicy'] == 'Always' ? 'selected' : '' }} value="Always">Always</option>
                                                <option {{ $key['imagePullPolicy'] == 'IfNotPresent' ? 'selected' : '' }} value="IfNotPresent">IfNotPresent</option>
                                                <option {{ $key['imagePullPolicy'] == 'Never' ? 'selected' : '' }} value="Never">Never</option>
                                            </select>
                                            @error("containers.$index.imagePullPolicy")
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Container Configuration -->
                                    <div>
                                        <!-- Ports -->
                                        <div class="mb-6">
                                            <h5 class="text-sm font-medium text-gray-700 mb-3">Ports</h5>
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                                onclick="addPort({{ $index }})">
                                                <svg class="-ml-1 mr-1 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                                </svg>
                                                Add Port
                                            </button>

                                            <div id="ports-{{$index}}" class="mt-3 space-y-2">
                                                @if(old("containers.$index.ports"))
                                                @foreach(old("containers.$index.ports") as $indexPort => $keyPort)
                                                <div class="flex items-center space-x-2 bg-gray-50 p-2 rounded-lg border border-gray-200">
                                                    <div class="flex-1">
                                                        <input type="text"
                                                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-1.5 border border-gray-300 rounded-md @error(" containers.$index.ports.$indexPort") border-red-500 @enderror"
                                                            name="containers[{{$index}}][ports][{{$indexPort}}]"
                                                            value="{{ $keyPort ?? '' }}"
                                                            placeholder="80">
                                                    </div>
                                                    <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                @error("containers.$index.ports.$indexPort")
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Environment Variables -->
                                        <div>
                                            <h5 class="text-sm font-medium text-gray-700 mb-3">Environment Variables</h5>
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                                onclick="addEnv({{ $index }})">
                                                <svg class="-ml-1 mr-1 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                                </svg>
                                                Add Environment Variable
                                            </button>

                                            <div id="env-{{$index}}" class="mt-3 space-y-2">
                                                @if(old("containers.$index.env.key") && old("containers.$index.env.value"))
                                                @foreach(old("containers.$index.env.key") as $indexEnv => $keyEnv)
                                                <div class="flex items-center space-x-2 bg-gray-50 p-2 rounded-lg border border-gray-200">
                                                    <div class="flex-1 grid grid-cols-2 gap-2">
                                                        <input type="text"
                                                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-1.5 border border-gray-300 rounded-md @error(" containers.$index.env.key.$indexEnv") border-red-500 @enderror"
                                                            name="containers[{{$index}}][env][key][{{$indexEnv}}]"
                                                            value="{{ old("containers.$index.env.key.$indexEnv") }}"
                                                            placeholder="KEY">
                                                        <input type="text"
                                                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-3 py-1.5 border border-gray-300 rounded-md @error(" containers.$index.env.value.$indexEnv") border-red-500 @enderror"
                                                            name="containers[{{$index}}][env][value][{{$indexEnv}}]"
                                                            value="{{ old("containers.$index.env.value.$indexEnv") }}"
                                                            placeholder="value">
                                                    </div>
                                                    <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                @error("containers.$index.env.key.$indexEnv")
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                                @error("containers.$index.env.value.$indexEnv")
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                                @endforeach
                                                @endif
                                            </div>
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

                    <!-- Pod Settings Section -->
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <span class="flex-shrink-0 bg-indigo-100 text-indigo-700 rounded-full h-6 w-6 flex items-center justify-center mr-2">
                                <span class="text-sm font-semibold">4</span>
                            </span>
                            Pod Settings
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Restart Policy -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Restart Policy <span class="text-red-500">*</span></label>
                                <select name="restartpolicy"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-2 border border-gray-300 rounded-lg @error('restartpolicy') border-red-500 @enderror">
                                    <option {{ old('restartpolicy') == 'Always' ? 'selected' : '' }} value="Always">Always</option>
                                    <option {{ old('restartpolicy') == 'OnFailure' ? 'selected' : '' }} value="OnFailure">OnFailure</option>
                                    <option {{ old('restartpolicy') == 'Never' ? 'selected' : '' }} value="Never">Never</option>
                                </select>
                                @error('restartpolicy')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @else
                                <p class="mt-1 text-sm text-gray-500">Defines the restart behavior if a container exits.</p>
                                @enderror
                            </div>

                            <!-- Grace Period -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Termination Grace Period (seconds)</label>
                                <input type="text"
                                    name="graceperiod"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-2 border border-gray-300 rounded-lg @error('graceperiod') border-red-500 @enderror"
                                    value="{{ old('graceperiod') }}"
                                    placeholder="30">
                                @error('graceperiod')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @else
                                <p class="mt-1 text-sm text-gray-500">Time given to the pod to terminate gracefully.</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('Pods.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Back to Pods
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Create Pod
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
                    <h3 class="ml-2 text-lg font-medium text-indigo-900">About Kubernetes Pods</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="prose max-w-none">
                    <p>Pods are the smallest deployable units of computing that you can create and manage in Kubernetes. A Pod is a group of one or more containers, with shared storage and network resources, and a specification for how to run the containers.</p>
                    <h4>Key Concepts:</h4>
                    <ul>
                        <li>Pods run on nodes in your cluster</li>
                        <li>Each pod has a unique IP address within the cluster</li>
                        <li>Containers within a pod share the same network namespace</li>
                        <li>Pods are ephemeral by nature and are not designed to run forever</li>
                        <li>For long-running applications, use higher-level controllers like Deployments</li>
                    </ul>
                    <p class="text-sm text-gray-500 mt-4">For more information, refer to the <a href="https://kubernetes.io/docs/concepts/workloads/pods/" class="text-indigo-600 hover:text-indigo-900" target="_blank">Kubernetes documentation</a>.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Include the pod creation script -->
    @include('template/resource_creation/createPod')

    <script>
        // Make sure containerCount is initialized
        if (typeof containerCount === 'undefined') {
            let containerCount = 0;
        }

        // Override the appendInput function for containers
        window.appendInput = function(baseDivName, inputName) {
            const baseDiv = document.getElementById(baseDivName);

            // Handle labels and annotations using the original function
            if (baseDivName === 'labels' || baseDivName === 'annotations') {
                const baseInput = document.createElement('div');
                baseInput.className = 'dynamic-input';
                baseInput.innerHTML = `
                <div class="flex flex-wrap items-center space-x-2 p-3 bg-white rounded-lg border border-gray-200 shadow-sm">
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
                </div>
                `;
                baseDiv.appendChild(baseInput);
                return;
            }

            // Custom implementation for containers
            if (baseDivName === 'containers') {
                const newIndex = containerCount++;

                const newContainer = document.createElement('div');
                newContainer.className = 'bg-white p-5 rounded-lg border border-gray-200 shadow-sm dynamic-input';

                // Create the container HTML with proper Tailwind classes
                const containerHTML = `
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-medium text-gray-900 flex items-center">
                            <svg class="h-5 w-5 text-indigo-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Container #${newIndex}
                        </h4>
                        <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Container Basic Info -->
                        <div>
                            <h5 class="text-sm font-medium text-gray-700 mb-3">Basic Information</h5>
                            
                            <!-- Container Name -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Container Name <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       name="containers[${newIndex}][name]" 
                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-2 border border-gray-300 rounded-lg" 
                                       placeholder="my-container">
                            </div>
                            
                            <!-- Container Image -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Container Image <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       name="containers[${newIndex}][image]" 
                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-2 border border-gray-300 rounded-lg" 
                                       placeholder="nginx:latest">
                            </div>
                            
                            <!-- Image Pull Policy -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Image Pull Policy <span class="text-red-500">*</span></label>
                                <select name="containers[${newIndex}][imagePullPolicy]" 
                                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-2 border border-gray-300 rounded-lg">
                                    <option value="Always">Always</option>
                                    <option value="IfNotPresent" selected>IfNotPresent</option>
                                    <option value="Never">Never</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Container Configuration -->
                        <div>
                            <!-- Ports -->
                            <div class="mb-6">
                                <h5 class="text-sm font-medium text-gray-700 mb-3">Ports</h5>
                                <button type="button" 
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                        onclick="addPort(${newIndex})">
                                    <svg class="-ml-1 mr-1 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Add Port
                                </button>
                                
                                <div id="ports-${newIndex}" class="mt-3 space-y-2">
                                </div>
                            </div>
                            
                            <!-- Environment Variables -->
                            <div>
                                <h5 class="text-sm font-medium text-gray-700 mb-3">Environment Variables</h5>
                                <button type="button" 
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                        onclick="addEnv(${newIndex})">
                                    <svg class="-ml-1 mr-1 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Add Environment Variable
                                </button>
                                
                                <div id="env-${newIndex}" class="mt-3 space-y-2">
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                newContainer.innerHTML = containerHTML;
                baseDiv.appendChild(newContainer);
                return;
            }
        };

        // Function to add a port to a container
        window.addPort = function(containerIndex) {
            const portsContainer = document.getElementById(`ports-${containerIndex}`);

            const newPort = document.createElement('div');
            newPort.className = 'flex items-center space-x-2 mb-3 dynamic-input';

            newPort.innerHTML = `
                <div class="flex-grow">
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Port</span>
                        </div>
                        <input type="text" 
                               class="pl-14 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                               name="containers[${containerIndex}][ports][]" 
                               placeholder="80">
                    </div>
                </div>
                <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;

            portsContainer.appendChild(newPort);
        };

        // Function to add an environment variable to a container
        window.addEnv = function(containerIndex) {
            const envContainer = document.getElementById(`env-${containerIndex}`);

            const newEnv = document.createElement('div');
            newEnv.className = 'flex items-center space-x-2 bg-gray-50 p-2 rounded-lg border border-gray-200 dynamic-input';

            newEnv.innerHTML = `
                <div class="flex-grow">
                    <input type="text" 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                           name="containers[${containerIndex}][env][key][]" 
                           placeholder="KEY_NAME">
                </div>
                <div class="flex-grow">
                    <input type="text" 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                           name="containers[${containerIndex}][env][value][]" 
                           placeholder="value">
                </div>
                <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;

            envContainer.appendChild(newEnv);
        };

        // Event delegation for remove buttons

        function addContainer(containerId) {
            const container = document.getElementById(containerId);
            const newIndex = containerCount++;

            const newContainer = document.createElement('div');
            newContainer.className = 'bg-white p-5 rounded-lg border border-gray-200 shadow-sm dynamic-input';
            newContainer.innerHTML = `
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-lg font-medium text-gray-900 flex items-center">
                    <svg class="h-5 w-5 text-indigo-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Container #${newIndex}
                </h4>
                <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h5 class="text-sm font                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Container Name <span class="text-red-500">*</span></label>
                        <input type="text" name="containers[${newIndex}][name]" class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="my-container">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Container Image <span class="text-red-500">*</span></label>
                        <input type="text" name="containers[${newIndex}][image]" class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" placeholder="nginx:latest">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Image Pull Policy <span class="text-red-500">*</span></label>
                        <select name="containers[${newIndex}][imagePullPolicy]" class="block w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="Always">Always</option>
                            <option value="IfNotPresent" selected>IfNotPresent</option>
                            <option value="Never">Never</option>
                        </select>
                    </div>
                </div>

                <div>
                    <div class="mb-6">
                        <h5 class="text-sm font-medium text-gray-700 mb-3">Ports</h5>
                        <button type="button" onclick="addPort(${newIndex})" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Add Port
                        </button>
                        <div id="ports-${newIndex}" class="mt-3 space-y-2"></div>
                    </div>
                    <div>
                        <h5 class="text-sm font-medium text-gray-700 mb-3">Environment Variables</h5>
                        <button type="button" onclick="addEnv(${newIndex})" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Add Environment Variable
                        </button>
                        <div id="env-${newIndex}" class="mt-3 space-y-2"></div>
                    </div>
                </div>
            </div>
        `;

            container.appendChild(newContainer);
        }

        // Delegação de eventos para botões de remoção
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeInput') || e.target.closest('.removeInput')) {
                const button = e.target.classList.contains('removeInput') ? e.target : e.target.closest('.removeInput');
                const parent = button.closest('.dynamic-input');
                if (parent) {
                    parent.remove();
                } else {
                    button.closest('.flex.items-center')?.remove();
                }
            }
        });


        // Function to add a port to a container
        window.addPort = function(containerIndex) {
            const portsContainer = document.getElementById(`ports-${containerIndex}`);

            const newPort = document.createElement('div');
            newPort.className = 'flex items-center space-x-2 bg-gray-50 p-3 rounded-lg border border-gray-200 dynamic-input';

            const portHTML = `
                <div class="flex-grow">
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Port</span>
                        </div>
                        <input type="text" 
                               class="pl-14 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                               name="containers[${containerIndex}][ports][]" 
                               placeholder="80">
                    </div>
                </div>
                <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;

            newPort.innerHTML = portHTML;
            portsContainer.appendChild(newPort);
        };

        // Function to add an environment variable to a container
        window.addEnv = function(containerIndex) {
            const envContainer = document.getElementById(`env-${containerIndex}`);

            const newEnv = document.createElement('div');
            newEnv.className = 'flex items-center space-x-2 bg-gray-50 p-3 rounded-lg border border-gray-200 dynamic-input';

            const envHTML = `
                <div class="flex-grow">
                    <input type="text" 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                           name="containers[${containerIndex}][env][key][]" 
                           placeholder="KEY_NAME">
                </div>
                <div class="flex-grow">
                    <input type="text" 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                           name="containers[${containerIndex}][env][value][]" 
                           placeholder="value">
                </div>
                <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            `;

            newEnv.innerHTML = envHTML;
            envContainer.appendChild(newEnv);
        };

        // Event delegation for remove buttons
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeInput') || e.target.closest('.removeInput')) {
                const button = e.target.classList.contains('removeInput') ? e.target : e.target.closest('.removeInput');
                const parent = button.closest('.dynamic-input');
                if (parent) {
                    parent.remove();
                } else {
                    const flexContainer = button.closest('.flex.items-center');
                    if (flexContainer) {
                        flexContainer.remove();
                    }
                }
            }
        });
    </script>
</x-app-layout>