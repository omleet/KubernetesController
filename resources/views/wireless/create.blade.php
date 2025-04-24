<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col space-y-1">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Add New Wireless Interface
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Configure a new wireless interface on the device
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
            <!-- Wireless Form Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Wireless Interface Configuration</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Set up a new wireless interface</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('Wireless.store', $deviceParam) }}">
                        @csrf
                        <div class="space-y-6">
                            <!-- SSID Field -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <label for="ssid" class="block text-sm font-medium text-gray-700 dark:text-gray-300">SSID*</label>
                                <input type="text" id="ssid" name="ssid" value="{{ old('ssid') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('ssid') border-red-500 @enderror"
                                       placeholder="My-WiFi" required>
                                @error('ssid')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Master Interface Field -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <label for="master-interface" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Master Interface*</label>
                                <select id="master-interface" name="master-interface" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('master-interface') border-red-500 @enderror">
                                    @foreach ($interfaces as $interface)
                                        @if (isset($interface['band']))
                                            <option value="{{ $interface['name'] }}">
                                                {{ $interface['ssid'] }} ({{ $interface['name'] }}, {{ $interface['band'] }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('master-interface')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Security Profile Field -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <label for="security-profile" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Security Profile*</label>
                                <select id="security-profile" name="security-profile" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('security-profile') border-red-500 @enderror">
                                    @foreach ($security_profiles as $security_profile)
                                        <option>{{ $security_profile['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('security-profile')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- WPS Mode Field -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <label for="wps-mode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">WPS Mode</label>
                                <select id="wps-mode" name="wps-mode" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('wps-mode') border-red-500 @enderror">
                                    <option value="disabled">Disabled</option>
                                    <option value="push-button">Push button</option>
                                    <option value="push-button-5s">Push button 5 seconds</option>
                                    <option value="virtual-push-button-only">Virtual push button only</option>
                                </select>
                                @error('wps-mode')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Options Checkboxes -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Options</label>
                                <div class="flex flex-wrap gap-4 mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="default-authentication" value="true" checked
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 rounded border-gray-300 dark:bg-gray-800 dark:border-gray-700 @error('default-authentication') border-red-500 @enderror">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Default Authenticate</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="default-forwarding" value="true" checked
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 rounded border-gray-300 dark:bg-gray-800 dark:border-gray-700 @error('default-forwarding') border-red-500 @enderror">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Default Forward</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="hide-ssid" value="true"
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 rounded border-gray-300 dark:bg-gray-800 dark:border-gray-700 @error('hide-ssid') border-red-500 @enderror">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Hide SSID</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-gradient-to-r from-indigo-600 to-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Create Wireless Interface
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Custom JSON Request Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 p-3 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Advanced Configuration</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Custom JSON request for advanced users</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('wireless_storeCustom', $deviceParam) }}">
                        @csrf
                        <div class="space-y-4">
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                    Check the <a href="https://help.mikrotik.com/docs/display/ROS" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Mikrotik Support</a> for the correct parameters
                                </p>
                                <textarea id="custom" name="custom" rows="8"
                                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('custom') border-red-500 @enderror">{{ old('custom') }}</textarea>
                                @error('custom')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end space-x-3 pt-2">
                                <button type="button" onclick="prettyPrint()" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                                    Beautify JSON
                                </button>
                                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-gradient-to-r from-purple-600 to-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Submit Custom Request
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>