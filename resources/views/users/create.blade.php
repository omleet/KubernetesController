<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900 ">
                Create New User
            </h2>
            <p class="mt-1 text-sm text-gray-500 ">
                Add a new user to the system
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-gradient-to-br from-white to-gray-50   rounded-xl shadow-lg border border-gray-100 ">
                <div class="p-8">
                    <div class="flex items-center mb-8">
                        <div class="flex-shrink-0 p-3 bg-indigo-100  rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900 ">User Information</h3>
                            <p class="text-sm text-gray-500 ">Fill in the details for the new user</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('User.store') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Full Name')"  />
                            <x-text-input id="name" name="name" type="text" 
                                         class="block w-full mt-1   " 
                                         :value="old('name')" required autofocus 
                                         placeholder="Enter full name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 " />
                        </div>

                        <!-- Email -->
                        <div>
                            <x-input-label for="email" :value="__('Email Address')"  />
                            <x-text-input id="email" name="email" type="email" 
                                         class="block w-full mt-1   " 
                                         :value="old('email')" required 
                                         placeholder="Enter email address" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 " />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')"  />
                            <x-text-input id="password" name="password" type="password" 
                                         class="block w-full mt-1   " 
                                         required 
                                         placeholder="Create a password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 " />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')"  />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" 
                                         class="block w-full mt-1   " 
                                         required 
                                         placeholder="Confirm password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 " />
                        </div>

                        <!-- Admin Checkbox -->
                        <div class="flex items-center mt-6">
                            <div class="flex items-center h-5">
                                <input id="admin" name="admin" type="checkbox" value="1" 
                                       class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500    "
                                       {{ old('admin') == "1" ? 'checked' : '' }}>
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="admin" class="font-medium text-gray-700 ">Grant Administrator Privileges</label>
                                <p class="text-gray-500 ">This user will have full system access</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <x-primary-button class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                {{ __('Create User') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>