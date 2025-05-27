<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
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
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center ">


                    <x-nav-link :href="route('Clusters.index')" :active="request()->routeIs('Clusters.*')">
                        {{ __('Clusters') }}
                    </x-nav-link>

                    @if(auth()->user()->admin == 1)
                    <x-nav-link :href="route('users_all')" :active="request()->routeIs('users_all')">
                        {{ __('Users') }}
                    </x-nav-link>
                    @endif

                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                        {{ __('About') }}
                    </x-nav-link>

                    @if(session('clusterId'))
                    <div x-data="{ open: false }" class="relative">
                        <!-- Trigger com estilo semelhante a x-nav-link -->
                        <button @click="open = !open"
                            class="inline-flex items-center px-1 pt-1  border-b-2 text-sm font-medium leading-5 focus:outline-none transition
                       duration-150 ease-in-out
                       border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300"
                            :class="{ 'border-indigo-500 text-gray-900': open }">
                            {{ __('Cluster Resources') }}
                            <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8l5 5 5-5" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
                            style="display: none;">

                            <x-nav-link :href="route('Dashboard')" :active="request()->routeIs('Dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>

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
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Mobile Menu Items -->
            <x-responsive-nav-link :href="route('Clusters.index')" :active="request()->routeIs('Clusters.index')">
                {{ __('Clusters') }}
            </x-responsive-nav-link>
            <!-- Repete aqui os outros links conforme acima -->
        </div>
    </div>
</nav>