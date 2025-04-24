<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col space-y-1">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Security Profile "{{$security_profile['name']}}"
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Detailed information about the security profile "{{$security_profile['name']}}"
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
            <!-- Security Profile Details Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Profile Details</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Configuration and settings for this security profile</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                        <!-- Profile Attributes -->
                        <div class="space-y-6">
                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Basic Information</h4>
                                <dl class="space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white font-mono">{{isset($security_profile['name']) ? $security_profile['name'] : '-'}}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Mode</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{isset($security_profile['mode']) ? $security_profile['mode'] : '-'}}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Authentication Types</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{isset($security_profile['authentication-types']) ? $security_profile['authentication-types'] : '-'}}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Encryption Settings</h4>
                                <dl class="space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Unicast Ciphers</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{isset($security_profile['unicast-ciphers']) ? $security_profile['unicast-ciphers'] : '-'}}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Group Ciphers</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{isset($security_profile['group-ciphers']) ? $security_profile['group-ciphers'] : '-'}}</dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="p-4 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Advanced Settings</h4>
                                <dl class="space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Group Key Update</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{isset($security_profile['group-key-update']) ? $security_profile['group-key-update'] : '-'}}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Management Protection</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{isset($security_profile['management-protection']) ? $security_profile['management-protection'] : '-'}}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">PMKID</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{isset($security_profile['disable-pmkid']) ? $security_profile['disable-pmkid'] : '-'}}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- JSON Data -->
                        <div>
                            <div class="p-6 bg-white dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700 h-full">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Raw Data</h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400">
                                        JSON Format
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    Complete security profile data in JSON format for debugging and reference.
                                </p>
                                <div class="p-4 overflow-auto text-sm bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <pre class="text-gray-800 dark:text-gray-300 font-mono text-xs">{{$json}}</pre>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('SecurityProfiles.index', $deviceParam) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600">
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