<nav x-data="{ isOpen: false, dropdownOpen: false }" class="bg-white border-b border-gray-100">
    <!-- Top Navigation Bar -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('Clusters.index') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center">
                    <x-nav-link :href="route('Clusters.index')" :active="request()->routeIs('Clusters.*')">
                        {{ __('Clusters') }}
                    </x-nav-link>

                    @if(auth()->user()->admin == 1)
                    <x-nav-link :href="route('users_all')" :active="request()->routeIs('users_all')">
                        {{ __('Users') }}
                    </x-nav-link>
                    @endif

                    @if(session('clusterId'))
                    <div x-data="{ isOpen: false }" class="relative">
                        <!-- Botão com texto "Cluster Resources" -->
                        <button @click="isOpen = !isOpen"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Cluster Resources') }}
                            <!-- Ícone de seta -->
                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu (mantido igual) -->
                        <div x-show="isOpen" @click.away="isOpen = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                            style="display: none;">
                            <div class="py-1">
                                <a href="{{ route('Dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Dashboard') }}</a>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('Nodes.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Nodes') }}</a>
                            </div>
                            @if(Auth::user()->resources === '[*]' || str_contains(Auth::user()->resources, 'Namespaces'))
                            <div class="py-1">
                                <a href="{{ route('Namespaces.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Namespaces') }}</a>
                            </div>
                            @endif
                            @if(Auth::user()->resources === '[*]' || str_contains(Auth::user()->resources, 'Pods'))
                            <div class="py-1">
                                <a href="{{ route('Pods.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Pods') }}</a>
                            </div>
                            @endif
                            @if(Auth::user()->resources === '[*]' || str_contains(Auth::user()->resources, 'Deployments'))
                            <div class="py-1">
                                <a href="{{ route('Deployments.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Deployments') }}</a>
                            </div>
                            @endif
                            @if(Auth::user()->resources === '[*]' || str_contains(Auth::user()->resources, 'Services'))
                            <div class="py-1">
                                <a href="{{ route('Services.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Services') }}</a>
                            </div>
                            @endif
                            @if(Auth::user()->resources === '[*]' || str_contains(Auth::user()->resources, 'Ingresses'))
                            <div class="py-1">
                                <a href="{{ route('Ingresses.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Ingresses') }}</a>
                            </div>
                            @endif
                            @if(Auth::user()->resources === '[*]' || str_contains(Auth::user()->resources, 'CustomResource'))
                            <div class="py-1">
                                <a href="{{ route('CustomResources.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Create Resource') }}</a>
                            </div>
                            @endif
                            @if(Auth::user()->resources === '[*]' || str_contains(Auth::user()->resources, 'Backups'))
                            <div class="py-1">
                                <a href="{{ route('Backups.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ __('Backups') }}</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                        {{ __('About') }}
                    </x-nav-link>
                </div>
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

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="isOpen = !isOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <!-- Ícone Hamburger -->
                    <svg x-show="!isOpen" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Ícone X (fechar) -->
                    <svg x-show="isOpen" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="isOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="sm:hidden">

        <div class="pt-2 pb-3 space-y-1 bg-white shadow-md rounded-lg mx-4 my-2 px-4">
            <x-responsive-nav-link :href="route('Clusters.index')" :active="request()->routeIs('Clusters.*')" @click="isOpen = false">
                {{ __('Clusters') }}
            </x-responsive-nav-link>

            @if(auth()->user()->admin == 1)
            <x-responsive-nav-link :href="route('users_all')" :active="request()->routeIs('users_all')" @click="isOpen = false">
                {{ __('Users') }}
            </x-responsive-nav-link>
            @endif

            @if(session('clusterId'))
            <div x-data="{ mobileDropdownOpen: false }" class="space-y-1">
                <button @click="mobileDropdownOpen = !mobileDropdownOpen"
                    class="w-full flex items-center justify-between px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition duration-150 ease-in-out">
                    <span>{{ __('Cluster Resources') }}</span>
                    <svg class="ml-2 h-4 w-4" :class="{ 'transform rotate-180': mobileDropdownOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="mobileDropdownOpen" class="space-y-1 pl-4">
                    <x-responsive-nav-link :href="route('Dashboard')" @click="isOpen = false">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('Nodes.index')" @click="isOpen = false">
                        {{ __('Nodes') }}
                    </x-responsive-nav-link>

                    @if(Auth::user()->resources === '[*]' || str_contains(Auth::user()->resources, 'Namespaces'))
                    <x-responsive-nav-link :href="route('Namespaces.index')" @click="isOpen = false">
                        {{ __('Namespaces') }}
                    </x-responsive-nav-link>
                    @endif
                    @if(Auth::user()->resources === '[*]' || str_contains(Auth::user()->resources, 'Pods'))
                    <x-responsive-nav-link :href="route('Pods.index')" @click="isOpen = false">
                        {{ __('Pods') }}
                    </x-responsive-nav-link>
                    @endif
                    @if(Auth::user()->resources === '[*]' || str_contains(Auth::user()->resources, 'Deployments'))
                    <x-responsive-nav-link :href="route('Deployments.index')" @click="isOpen = false">
                        {{ __('Deployments') }}
                    </x-responsive-nav-link>
                    @endif
                    @if(Auth::user()->resources === '[*]' || str_contains(Auth::user()->resources, 'Services'))
                    <x-responsive-nav-link :href="route('Services.index')" @click="isOpen = false">
                        {{ __('Services') }}
                    </x-responsive-nav-link>
                    @endif
                    @if(Auth::user()->resources === '[*]' || str_contains(Auth::user()->resources, 'Ingresses'))
                    <x-responsive-nav-link :href="route('Ingresses.index')" @click="isOpen = false">
                        {{ __('Ingresses') }}
                    </x-responsive-nav-link>
                    @endif
                    @if(Auth::user()->resources === '[*]' || str_contains(Auth::user()->resources, 'CustomResource'))
                    <x-responsive-nav-link :href="route('CustomResources.index')" @click="isOpen = false">
                        {{ __('Create Resource') }}
                    </x-responsive-nav-link>
                    @endif
                    @if(Auth::user()->resources === '[*]' || str_contains(Auth::user()->resources, 'Backups'))
                    <x-responsive-nav-link :href="route('Backups.index')" @click="isOpen = false">
                        {{ __('Backups') }}
                    </x-responsive-nav-link>
                    @endif
                </div>
            </div>
            @endif

            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')" @click="isOpen = false">
                {{ __('About') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 bg-white mx-4 my-2 px-4 rounded-lg">
            <div class="flex items-center px-4">
                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" @click="isOpen = false">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" @click="isOpen = false">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>


</nav>