<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col space-y-1">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Edit DNS Server
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Configure the device's DNS server settings
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
            <!-- DNS Server Form Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">DNS Server Configuration</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Update the DNS server parameters</p>
                        </div>
                    </div>

                    <form method="POST" action="{{route('storeDnsServer', $deviceParam)}}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- DNS Servers -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="servers" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">DNS Servers</label>
                                <input type="text" id="servers" name="servers" value="{{$server['servers']}}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('servers') border-red-500 @enderror"
                                    placeholder="9.9.9.9,1.1.1.1">
                                @error('servers')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- DoH Servers -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="use-doh-server" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">DoH Servers</label>
                                <input type="text" id="use-doh-server" name="use-doh-server" value="{{$server['use-doh-server']}}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('use-doh-server') border-red-500 @enderror"
                                    placeholder="9.9.9.9,1.1.1.1">
                                @error('use-doh-server')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- DoH Settings -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="doh-max-server-connections" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">DoH Max Connections</label>
                                <input type="text" id="doh-max-server-connections" name="doh-max-server-connections" value="{{$server['doh-max-server-connections']}}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('doh-max-server-connections') border-red-500 @enderror"
                                    placeholder="5">
                                @error('doh-max-server-connections')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="doh-max-concurrent-queries" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">DoH Max Queries</label>
                                <input type="text" id="doh-max-concurrent-queries" name="doh-max-concurrent-queries" value="{{$server['doh-max-concurrent-queries']}}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('doh-max-concurrent-queries') border-red-500 @enderror"
                                    placeholder="50">
                                @error('doh-max-concurrent-queries')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="doh-timeout" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">DoH Timeout</label>
                                <input type="text" id="doh-timeout" name="doh-timeout" value="{{$server['doh-timeout']}}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('doh-timeout') border-red-500 @enderror"
                                    placeholder="HH:MM:SS">
                                @error('doh-timeout')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- UDP Settings -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="max-udp-packet-size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max UDP Packet Size</label>
                                <input type="text" id="max-udp-packet-size" name="max-udp-packet-size" value="{{$server['max-udp-packet-size']}}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('max-udp-packet-size') border-red-500 @enderror"
                                    placeholder="4096">
                                @error('max-udp-packet-size')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Timeout Settings -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="query-server-timeout" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Query Server Timeout</label>
                                <input type="text" id="query-server-timeout" name="query-server-timeout" value="{{$server['query-server-timeout']}}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('query-server-timeout') border-red-500 @enderror"
                                    placeholder="2">
                                @error('query-server-timeout')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="query-total-timeout" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Query Total Timeout</label>
                                <input type="text" id="query-total-timeout" name="query-total-timeout" value="{{$server['query-total-timeout']}}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('query-total-timeout') border-red-500 @enderror"
                                    placeholder="10">
                                @error('query-total-timeout')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Cache Settings -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="cache-size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cache Size</label>
                                <input type="text" id="cache-size" name="cache-size" value="{{$server['cache-size']}}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('cache-size') border-red-500 @enderror"
                                    placeholder="2048">
                                @error('cache-size')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="cache-max-ttl" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cache Max TTL</label>
                                <input type="text" id="cache-max-ttl" name="cache-max-ttl" value="{{$server['cache-max-ttl']}}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('cache-max-ttl') border-red-500 @enderror"
                                    placeholder="HH:MM:SS">
                                @error('cache-max-ttl')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Other Settings -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="address-list-extra-time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address List Extra Time</label>
                                <input type="text" id="address-list-extra-time" name="address-list-extra-time" value="{{$server['address-list-extra-time']}}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('address-list-extra-time') border-red-500 @enderror"
                                    placeholder="100">
                                @error('address-list-extra-time')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="max-concurrent-queries" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Concurrent Queries</label>
                                <input type="text" id="max-concurrent-queries" name="max-concurrent-queries" value="{{$server['max-concurrent-queries']}}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('max-concurrent-queries') border-red-500 @enderror"
                                    placeholder="100">
                                @error('max-concurrent-queries')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <label for="max-concurrent-tcp-sessions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max TCP Sessions</label>
                                <input type="text" id="max-concurrent-tcp-sessions" name="max-concurrent-tcp-sessions" value="{{$server['max-concurrent-tcp-sessions']}}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white @error('max-concurrent-tcp-sessions') border-red-500 @enderror"
                                    placeholder="20">
                                @error('max-concurrent-tcp-sessions')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Checkbox -->
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="allow-remote-requests" name="allow-remote-requests" type="checkbox" value="true" {{ $server['allow-remote-requests'] == "true" ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 rounded border-gray-300 dark:bg-gray-800 dark:border-gray-700 @error('allow-remote-requests') border-red-500 @enderror">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="allow-remote-requests" class="font-medium text-gray-700 dark:text-gray-300">Allow remote requests</label>
                                        @error('allow-remote-requests')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-gradient-to-r from-indigo-600 to-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Update DNS Configuration
                            </button>
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

                    <form method="POST" action="{{route('dns_storeServerCustom', $deviceParam)}}">
                        @csrf
                        <div class="space-y-4">
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
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