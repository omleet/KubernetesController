<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col space-y-1">
            <h2 class="text-2xl font-bold text-gray-900 ">
                Add New IP Address
            </h2>
            <p class="text-sm text-gray-500 ">
                Configure a new IP address on the device
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
            <!-- IP Address Form Card -->
            <div class="bg-gradient-to-br from-white to-gray-50  rounded-xl shadow-lg overflow-hidden border border-gray-100 ">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 p-3 bg-indigo-100  rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 ">IP Address Configuration</h3>
                            <p class="text-sm text-gray-500 ">Set up a new IP address interface</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('IPAddresses.store', $deviceParam) }}">
                        @csrf
                        <div class="space-y-6">
                            <!-- Address Field -->
                            <div class="p-4 bg-gray-50  rounded-lg">
                                <label for="address" class="block text-sm font-medium text-gray-700 ">Address*</label>
                                <input type="text" id="address" name="address" value="{{ old('address') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm    @error('address') border-red-500 @enderror"
                                       placeholder="0.0.0.0/0" required>
                                @error('address')
                                    <p class="mt-2 text-sm text-red-600 ">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Network Field -->
                            <div class="p-4 bg-gray-50  rounded-lg">
                                <label for="network" class="block text-sm font-medium text-gray-700 ">Network</label>
                                <input type="text" id="network" name="network" value="{{ old('network') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm    @error('network') border-red-500 @enderror"
                                       placeholder="0.0.0.0">
                                @error('network')
                                    <p class="mt-2 text-sm text-red-600 ">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Interface Field -->
                            <div class="p-4 bg-gray-50  rounded-lg">
                                <label for="interface" class="block text-sm font-medium text-gray-700 ">Interface*</label>
                                <select id="interface" name="interface"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm    @error('interface') border-red-500 @enderror">
                                    @foreach ($interfaces as $interface)
                                        <option>{{ $interface['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('interface')
                                    <p class="mt-2 text-sm text-red-600 ">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-gradient-to-r from-indigo-600 to-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Create IP Address
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Custom JSON Request Card -->
            <div class="bg-gradient-to-br from-white to-gray-50  rounded-xl shadow-lg overflow-hidden border border-gray-100 ">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 p-3 bg-purple-100  rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 ">Advanced Configuration</h3>
                            <p class="text-sm text-gray-500 ">Custom JSON request for advanced users</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('address_storeCustom', $deviceParam) }}">
                        @csrf
                        <div class="space-y-4">
                            <div class="p-4 bg-gray-50  rounded-lg">
                                <p class="text-sm text-gray-500  mb-2">
                                    Check the <a href="https://help.mikrotik.com/docs/display/ROS" class="text-indigo-600 hover:text-indigo-500  ">Mikrotik Support</a> for the correct parameters
                                </p>
                                <textarea id="custom" name="custom" rows="8"
                                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm    @error('custom') border-red-500 @enderror">{{ old('custom') }}</textarea>
                                @error('custom')
                                    <p class="mt-2 text-sm text-red-600 ">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end space-x-3 pt-2">
                                <button type="button" onclick="prettyPrint()" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 ">
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