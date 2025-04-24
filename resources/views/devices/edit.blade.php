<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Edit MikroTik Device
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Update your MikroTik device configuration
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8 space-y-8">
            <!-- Edit Form Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <form method="POST" action="{{ route('Devices.update', $device['id']) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Device Information Section -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Device Information</h3>
                            
                            <!-- Device Name -->
                            <div>
                                <x-input-label for="name" :value="__('Device Name')" class="dark:text-gray-300" />
                                <x-text-input id="name" name="name" type="text" class="block w-full mt-1 dark:bg-gray-800 dark:border-gray-700 dark:text-white" 
                                            :value="old('name', $device['name'])" placeholder="e.g. Office Router" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2 dark:text-red-400" />
                            </div>
                        </div>

                        <!-- Credentials Section -->
                        <div class="space-y-6 p-6 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Connection Credentials</h3>
                            
                            <!-- Username -->
                            <div>
                                <x-input-label for="username" :value="__('Username')" class="dark:text-gray-300" />
                                <x-text-input id="username" name="username" type="text" class="block w-full mt-1 dark:bg-gray-800 dark:border-gray-700 dark:text-white" 
                                            :value="old('username', $device['username'])" placeholder="admin" required />
                                <x-input-error :messages="$errors->get('username')" class="mt-2 dark:text-red-400" />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300" />
                                <x-text-input id="password" name="password" type="password" class="block w-full mt-1 dark:bg-gray-800 dark:border-gray-700 dark:text-white" 
                                            :value="old('password', $device['password'])" placeholder="••••••" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2 dark:text-red-400" />
                            </div>
                        </div>

                        <!-- Connection Details Section -->
                        <div class="space-y-6 p-6 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Connection Details</h3>
                            
                            <!-- Endpoint -->
                            <div>
                                <x-input-label for="endpoint" :value="__('Endpoint')" class="dark:text-gray-300" />
                                <x-text-input id="endpoint" name="endpoint" type="text" class="block w-full mt-1 dark:bg-gray-800 dark:border-gray-700 dark:text-white" 
                                            :value="old('endpoint', $device['endpoint'])" placeholder="192.168.1.1" required />
                                <x-input-error :messages="$errors->get('endpoint')" class="mt-2 dark:text-red-400" />
                            </div>

                            <!-- Communication Method -->
                            <div>
                                <x-input-label for="method" :value="__('Communication Method')" class="dark:text-gray-300" />
                                <select id="method" name="method" class="block w-full mt-1 dark:bg-gray-800 dark:border-gray-700 dark:text-white rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 border-gray-300 dark:border-gray-600">
                                    <option value="http" {{ $device['method'] == "http" ? "selected" : "" }}>HTTP (Not secure but simpler access)</option>
                                    <option value="https" {{ $device['method'] == "https" ? "selected" : "" }}>HTTPS (Secure, needs SSL configured)</option>
                                </select>
                                <x-input-error :messages="$errors->get('method')" class="mt-2 dark:text-red-400" />
                            </div>

                            <!-- Timeout -->
                            <div>
                                <x-input-label for="timeout" :value="__('Timeout (seconds)')" class="dark:text-gray-300" />
                                <x-text-input id="timeout" name="timeout" type="text" class="block w-full mt-1 dark:bg-gray-800 dark:border-gray-700 dark:text-white" 
                                            :value="old('timeout', $device['timeout'])" placeholder="3" />
                                <x-input-error :messages="$errors->get('timeout')" class="mt-2 dark:text-red-400" />
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end">
                            <x-primary-button class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z" />
                                </svg>
                                {{ __('Update Device') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="max-w-xl">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 p-3 bg-red-100 dark:bg-red-900/30 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Delete Device</h3>
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                    Once the device is deleted, all of its resources and data will be permanently removed.
                                </p>
                                <div class="mt-5">
                                    <button onclick="_delete('Are you sure you want to delete this device?','{{ route("Devices.destroy", $device["id"]) }}')"
                                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-medium rounded-lg shadow-md transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete Device
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function _delete(message, action) {
            if (confirm(message)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = action;

                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';

                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';

                form.appendChild(csrf);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-app-layout>