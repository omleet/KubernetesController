<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col space-y-1">
            <h2 class="text-2xl font-bold text-gray-900 ">
                IP Address "{{ $address['address'] }}"
            </h2>
            <p class="text-sm text-gray-500 ">
                Detailed information about the IP address "{{ $address['address'] }}"
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
            <!-- IP Address Details Card -->
            <div class="bg-gradient-to-br from-white to-gray-50   rounded-xl shadow-lg overflow-hidden border border-gray-100 ">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-indigo-100  rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 ">IP Address Details</h3>
                                <p class="text-sm text-gray-500 ">Configuration and settings for this IP address</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                        <!-- IP Address Attributes -->
                        <div class="space-y-6">
                            <div class="p-4 bg-white  rounded-lg border border-gray-200 ">
                                <h4 class="text-lg font-medium text-gray-900  mb-4">Basic Information</h4>
                                <dl class="space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 ">Address</dt>
                                        <dd class="mt-1 text-sm text-gray-900  font-mono">{{ $address['address'] ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 ">Network</dt>
                                        <dd class="mt-1 text-sm text-gray-900  font-mono">{{ $address['network'] ?? '-' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 ">Interface</dt>
                                        <dd class="mt-1 text-sm text-gray-900 ">{{ $address['interface'] ?? '-' }}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="p-4 bg-white  rounded-lg border border-gray-200 ">
                                <h4 class="text-lg font-medium text-gray-900  mb-4">Additional Settings</h4>
                                <dl class="space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 ">Disabled</dt>
                                        <dd class="mt-1 text-sm text-gray-900 ">{{ $address['disabled'] ?? 'no' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 ">Dynamic</dt>
                                        <dd class="mt-1 text-sm text-gray-900 ">{{ $address['dynamic'] ?? 'no' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 ">Invalid</dt>
                                        <dd class="mt-1 text-sm text-gray-900 ">{{ $address['invalid'] ?? 'no' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- JSON Data -->
                        <div>
                            <div class="p-6 bg-white  rounded-lg border border-gray-200  h-full">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-medium text-gray-900 ">Raw Data</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800  ">
                                        JSON Format
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500  mb-4">
                                    Complete IP address configuration data in JSON format for debugging and reference.
                                </p>
                                <div class="p-4 overflow-auto text-sm bg-gray-50  rounded-lg border border-gray-200 ">
                                    <pre class="text-gray-800  font-mono text-xs">{{ $json }}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('IPAddresses.index', $deviceParam) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>