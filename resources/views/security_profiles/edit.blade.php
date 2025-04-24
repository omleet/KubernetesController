<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col space-y-1">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Edit Security Profile "{{$security_profile['name']}}"
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Update the security profile configuration
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
            <!-- Security Profile Edit Form Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Security Profile Configuration</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Update the settings for profile "{{$security_profile['name']}}"</p>
                        </div>
                    </div>

                    <form method="POST" action="{{route('SecurityProfiles.update', [$deviceParam, $security_profile['.id']])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <!-- Name Field -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                <input type="text" id="name" name="name" value="{{$security_profile['name']}}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('name') border-red-500 @enderror"
                                       placeholder="securityprofile1" required>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Mode Field -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="mode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mode</label>
                                <select id="mode" name="mode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                                    <option value="none" {{$security_profile['mode'] == "none" ? "selected" : ""}}>None</option>
                                    <option value="dynamic-keys" {{$security_profile['mode'] == "dynamic-keys" ? "selected" : ""}}>Dynamic Keys</option>
                                </select>
                                @error('mode')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Security Field -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Security (required if mode is dynamic keys)</label>
                                <div class="flex flex-wrap gap-4 mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="wpa2-psk" value="true" 
                                            {{strpos($security_profile['authentication-types'], "wpa2-psk") !== false ? "checked" : ""}}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">WPA2-PSK</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="wpa2-eap" value="true"
                                            {{strpos($security_profile['authentication-types'], "wpa2-eap") !== false ? "checked" : ""}}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">WPA2-EAP</span>
                                    </label>
                                </div>
                                @error('authentication-types')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Unicast Ciphers -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Unicast Ciphers (optional, for dynamic keys)</label>
                                <div class="flex flex-wrap gap-4 mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="uc-aes-ccm" value="true"
                                            {{strpos($security_profile['unicast-ciphers'], "aes-ccm") !== false ? "checked" : ""}}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">AES CCM</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="uc-tkip" value="true"
                                            {{strpos($security_profile['unicast-ciphers'], "tkip") !== false ? "checked" : ""}}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">TKIP</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Group Ciphers -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Group Ciphers (optional, for dynamic keys)</label>
                                <div class="flex flex-wrap gap-4 mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="gc-aes-ccm" value="true"
                                            {{strpos($security_profile['group-ciphers'], "aes-ccm") !== false ? "checked" : ""}}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">AES CCM</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="gc-tkip" value="true"
                                            {{strpos($security_profile['group-ciphers'], "tkip") !== false ? "checked" : ""}}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700">
                                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">TKIP</span>
                                    </label>
                                </div>
                            </div>

                            <!-- WPA2 Pre-Shared Key -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="wpa2-pre-shared-key" class="block text-sm font-medium text-gray-700 dark:text-gray-300">WPA2-Pre-Shared Key</label>
                                <input type="text" id="wpa2-pre-shared-key" name="wpa2-pre-shared-key" 
                                    value="{{$security_profile['wpa2-pre-shared-key']}}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                                    placeholder="Your SP password">
                                @error('wpa2-pre-shared-key')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Supplicant Identity -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="supplicant-identity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplicant Identity</label>
                                <input type="text" id="supplicant-identity" name="supplicant-identity" 
                                    value="{{$security_profile['supplicant-identity']}}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                                    placeholder="Your SP EAP supplicant">
                                @error('supplicant-identity')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Group Key Update -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="group-key-update" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Group Key Update</label>
                                <input type="text" id="group-key-update" name="group-key-update" 
                                    value="{{$security_profile['group-key-update']}}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                                    placeholder="HH:MM:SS">
                                @error('group-key-update')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Management Protection -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="management-protection" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Management Protection</label>
                                <select id="management-protection" name="management-protection" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                                    <option value="allowed" {{$security_profile['management-protection'] == "allowed" ? "selected" : ""}}>Allowed</option>
                                    <option value="disabled" {{$security_profile['management-protection'] == "disabled" ? "selected" : ""}}>Disabled</option>
                                    <option value="required" {{$security_profile['management-protection'] == "required" ? "selected" : ""}}>Required</option>
                                </select>
                                @error('management-protection')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Management Protection Key -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="management-protection-key" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Management Protection Key</label>
                                <input type="text" id="management-protection-key" name="management-protection-key" 
                                    value="{{$security_profile['management-protection-key']}}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                                    placeholder="Your management protection key">
                                @error('management-protection-key')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Disable PMKID -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label class="flex items-center">
                                    <input type="checkbox" name="disable-pmkid" value="true" 
                                        {{$security_profile['disable-pmkid'] == "true" ? "checked" : ""}}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-700">
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Disable PMKID</span>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-gradient-to-r from-indigo-600 to-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Update Profile
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

                    <form method="POST" action="{{route('sp_updateCustom',[$deviceParam, $security_profile['.id']])}}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
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