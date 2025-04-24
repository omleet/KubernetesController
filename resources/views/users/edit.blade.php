<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Edit User Profile
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Update user information and security settings
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8 space-y-8">
            <!-- Profile Information Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                            <span class="text-indigo-600 dark:text-indigo-400 text-xl font-medium">
                                {{ substr($user['name'], 0, 1) }}
                            </span>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Profile Information</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Update user's basic information</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('User.update', $user['id']) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Full Name')" class="dark:text-gray-300" />
                            <x-text-input id="name" name="name" type="text" 
                                         class="mt-1 block w-full dark:bg-gray-800 dark:border-gray-700 dark:text-white" 
                                         :value="old('name', $user['name'])" required autofocus 
                                         placeholder="Enter full name" />
                            <x-input-error class="mt-2 dark:text-red-400" :messages="$errors->get('name')" />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email Address')" class="dark:text-gray-300" />
                            <x-text-input id="email" name="email" type="email" 
                                         class="mt-1 block w-full dark:bg-gray-800 dark:border-gray-700 dark:text-white" 
                                         :value="old('email', $user['email'])" required 
                                         placeholder="Enter email address" />
                            <x-input-error class="mt-2 dark:text-red-400" :messages="$errors->get('email')" />
                        </div>

                        <!-- Admin Checkbox -->
                        @if (Auth::user()->admin == 1)
                        <div class="flex items-center mt-6">
                            <div class="flex items-center h-5">
                                <input id="admin" name="admin" type="checkbox" value="1" 
                                       class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                                       {{ $user['admin'] == 1 ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="admin" class="font-medium text-gray-700 dark:text-gray-300">Administrator Privileges</label>
                                <p class="text-gray-500 dark:text-gray-400">Grant full system access to this user</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-center justify-end mt-8">
                            <x-primary-button class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('Save Changes') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Update Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 p-3 bg-red-100 dark:bg-red-900/30 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Security Settings</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Update user's password</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('User.updatePassword', $user['id']) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- New Password -->
                        <div>
                            <x-input-label for="password" :value="__('New Password')" class="dark:text-gray-300" />
                            <x-text-input id="password" name="password" type="password" 
                                         class="mt-1 block w-full dark:bg-gray-800 dark:border-gray-700 dark:text-white" 
                                         required placeholder="Enter new password" />
                            <x-input-error class="mt-2 dark:text-red-400" :messages="$errors->get('password')" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="dark:text-gray-300" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" 
                                         class="mt-1 block w-full dark:bg-gray-800 dark:border-gray-700 dark:text-white" 
                                         required placeholder="Confirm new password" />
                            <x-input-error class="mt-2 dark:text-red-400" :messages="$errors->get('password_confirmation')" />
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <x-primary-button class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                {{ __('Update Password') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>