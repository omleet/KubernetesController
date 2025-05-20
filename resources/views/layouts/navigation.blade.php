<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16"> <!-- Esta div deve estar sempre visível -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-12 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Home') }}
                    </x-nav-link>

                    @if(auth()->user()->admin == 1)
                    <x-nav-link :href="route('users_all')" :active="request()->routeIs('users_all')">
                        {{ __('Users') }}
                    </x-nav-link>
                    @endif

                    <!-- Devices Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = ! open"
                            class="inline-flex items-center h-full px-1 pt-1 border-b-2 text-sm font-medium leading-5 text-gray-500
                                            transition duration-150 ease-in-out border-transparent hover:text-gray-700 hover:border-gray-300 focus:outline-none"
                            :class="{ 'border-indigo-400 text-gray-900 focus:border-indigo-700': open }">
                            {{ __('Devices') }}
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5"
                            style="display: none;">
                            @php
                            $selectedDevice = session('selectedDevice') ?? request()->route('Device');
                            @endphp

                            @if($selectedDevice)
                            <div class="py-1">
                                <a href="{{ route('Devices.index', $selectedDevice) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Device Information') }}</a>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('Interfaces.index', $selectedDevice) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Interfaces') }}</a>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('Bridges.index', $selectedDevice) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Bridges') }}</a>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('SecurityProfiles.index', $selectedDevice) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Security Profiles') }}</a>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('Wireless.index', $selectedDevice) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Wireless Interfaces') }}</a>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('IPAddresses.index', $selectedDevice) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('IP Adresses') }}</a>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('StaticRoutes.index', $selectedDevice) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Static Routing') }}</a>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('dhcp_servers', $selectedDevice) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('DHCP Servers') }}</a>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('dhcp_client', $selectedDevice) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('DHCP Client') }}</a>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('dns_server', $selectedDevice) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('DNS Server') }}</a>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('dns_records', $selectedDevice) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('DNS Static Records') }}</a>
                            </div>
                            
                            
                            @else
                            <div class="py-1">
                                <span class="block px-4 py-2 text-sm text-gray-400">Select a device first</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <x-nav-link class="hidden sm:flex sm:items-center sm:ms-6" href="{{ route('about') }}">
                    {{ __('About') }}
                </x-nav-link>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Home') }}
            </x-responsive-nav-link>

            @if(auth()->user()->admin == 1)
            <x-responsive-nav-link :href="route('users_all')" :active="request()->routeIs('users_all')">
                {{ __('Users') }}
            </x-responsive-nav-link>
            @endif

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    {{ __('Devices') }}
                    <svg class="fill-current h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" class="mt-1 bg-white rounded shadow-md">
                    @if($selectedDevice)
                    <a href="{{ route('Devices.index', $selectedDevice) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Device Information') }}</a>
                    <a href="{{ route('Interfaces.index', $selectedDevice) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Interfaces') }}</a>
                    <a href="{{ route('Bridges.index', $selectedDevice) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Bridges') }}</a>
                    <a href="{{ route('SecurityProfiles.index', $selectedDevice) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Security Profiles') }}</a>
                    <a href="{{ route('Wireless.index', $selectedDevice) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Wireless Interfaces') }}</a>
                    <a href="{{ route('IPAddresses.index', $selectedDevice) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('IP Adresses') }}</a>
                    <a href="{{ route('StaticRoutes.index', $selectedDevice) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Static Routing') }}</a>
                    <a href="{{ route('dhcp_servers', $selectedDevice) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('DHCP Server') }}</a>
                    <a href="{{ route('dhcp_client', $selectedDevice) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('DHCP Client') }}</a>
                    <a href="{{ route('dns_server', $selectedDevice) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('DNS Server') }}</a>
                    <a href="{{ route('dns_records', $selectedDevice) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('DNS Static Records') }}</a>
                    @else
                    <span class="block px-4 py-2 text-sm text-gray-400">Select a device first</span>
                    @endif
                </div>
            </div>
            <x-responsive-nav-link href="{{ route('about') }}">
                {{ __('About') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>