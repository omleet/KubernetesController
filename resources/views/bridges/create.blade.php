<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col space-y-1">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Create New Bridge
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Configure a new bridge interface on the device
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
            <!-- Bridge Form Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Bridge Configuration</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Set up a new bridge interface</p>
                        </div>
                    </div>

                    <form method="POST" action="{{route('Bridges.store', $deviceParam)}}">
                        @csrf
                        <div class="space-y-6">
                            <!-- Name Field -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name*</label>
                                <input type="text" id="name" name="name" value="{{old('name')}}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('name') border-red-500 @enderror" 
                                       placeholder="bridge1" required>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Ageing Time Field -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <label for="ageing-time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ageing time</label>
                                <input type="text" id="ageing-time" name="ageing-time" value="{{old('ageing-time')}}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('ageing-time') border-red-500 @enderror"
                                       placeholder="00:05:00">
                                @error('ageing-time')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- MTU Field -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <label for="mtu" class="block text-sm font-medium text-gray-700 dark:text-gray-300">MTU</label>
                                <input type="text" id="mtu" name="mtu" value="{{old('mtu')}}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('mtu') border-red-500 @enderror"
                                       placeholder="1500">
                                @error('mtu')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- MAC Address Field -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <label for="admin-mac" class="block text-sm font-medium text-gray-700 dark:text-gray-300">MAC Address</label>
                                <input type="text" id="admin-mac" name="admin-mac" value="{{old('admin-mac')}}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('admin-mac') border-red-500 @enderror"
                                       placeholder="AA:BB:CC:DD:EE:FF">
                                @error('admin-mac')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- DHCP Snooping Checkbox -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="dhcp-snooping" name="dhcp-snooping" type="checkbox" value="1"
                                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 rounded border-gray-300 dark:bg-gray-800 dark:border-gray-700 @error('dhcp-snooping') border-red-500 @enderror"
                                               {{ old('dhcp-snooping') ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="dhcp-snooping" class="font-medium text-gray-700 dark:text-gray-300">Enable DHCP Snooping</label>
                                        @error('dhcp-snooping')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-gradient-to-r from-indigo-600 to-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Create Bridge
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

                    <form method="POST" action="{{route('bridge_storeCustom', $deviceParam)}}">
                        @csrf
                        <div class="space-y-4">
                            <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                    Check the <a href="https://help.mikrotik.com/docs/display/ROS" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">Mikrotik Support</a> for the correct parameters
                                </p>
                                <textarea id="custom" name="custom" rows="8"
                                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('custom') border-red-500 @enderror">{{old('custom')}}</textarea>
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