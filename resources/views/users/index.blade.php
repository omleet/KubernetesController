<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <h2 class="text-2xl font-bold text-gray-900 ">
                User Management
            </h2>
            <p class="mt-1 text-sm text-gray-500 ">
                Manage all system users and their permissions
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-gradient-to-br from-white to-gray-50   rounded-xl shadow-lg border border-gray-100 ">
                <div class="p-8">
                    <!-- Header with Actions -->
                    <div class="flex flex-col justify-between mb-8 space-y-4 md:flex-row md:items-center md:space-y-0">
                        <!-- Add User Button -->
                        <a href="{{ route('User.create') }}" class="inline-flex items-center px-5 py-3 text-sm font-medium text-white bg-gradient-to-r from-green-600 to-emerald-600 rounded-lg shadow-md hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add New User
                        </a>

                        <!-- Search and Filters -->
                        <div class="flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                            <!-- Search Box -->
                            <div class="relative w-full sm:w-96">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 " fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" id="search" name="search" placeholder="Search users..."
                                    class="block w-full pl-10 pr-4 py-2.5 text-sm bg-white  border border-gray-300  rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500  "
                                    value="{{ request('search') }}">
                            </div>

                            <!-- Entries per Page -->
                            <select id="perPage" name="perPage"
                                class="block w-full px-4 py-2.5 text-sm bg-white  border border-gray-300  rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 ">
                                <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>Show 10</option>
                                <option value="25" {{ request('perPage', 10) == 25 ? 'selected' : '' }}>Show 25</option>
                                <option value="50" {{ request('perPage', 10) == 50 ? 'selected' : '' }}>Show 50</option>
                                <option value="100" {{ request('perPage', 10) == 100 ? 'selected' : '' }}>Show 100</option>
                            </select>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="overflow-x-auto rounded-lg border border-gray-200 ">
                        <table class="min-w-full divide-y divide-gray-200 ">
                            <thead class="bg-gray-50 ">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500  uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500  uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500  uppercase tracking-wider">Role</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-medium text-gray-500  uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white  divide-y divide-gray-200 ">
                                @foreach($users as $user)
                                <tr class="hover:bg-gray-50  transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100  flex items-center justify-center">
                                                <span class="text-indigo-600  font-medium">
                                                    {{ substr($user['name'], 0, 1) }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 ">{{ $user['name'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 ">{{ $user['email'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user['admin'] == 1 ? 'bg-green-100  text-green-800 ' : 'bg-blue-100  text-blue-800 ' }}">
                                            {{ $user['admin'] == 1 ? 'Administrator' : 'Standard User' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-3">
                                            <a href="{{ $user['id'] == Auth::user()->id ? route('User.me') : route('User.edit',$user['id']) }}" 
                                               class="text-indigo-600 hover:text-indigo-900   transition-colors"
                                               title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            @if (Auth::user()->id != $user['id'])
                                            <button onclick="_delete('Are you sure you want to delete the user &quot;{{$user["name"]}}&quot; ({{$user["id"]}})?','{{ route("User.destroy",$user['id']) }}')" 
                                                    class="text-red-600 hover:text-red-900   transition-colors"
                                                    title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination and Info -->
                    <div class="flex flex-col items-center justify-between mt-6 space-y-4 sm:flex-row sm:space-y-0">
                        <div class="text-sm text-gray-700 ">
                            Showing <span class="font-medium">{{ $users->firstItem() }}</span> to <span class="font-medium">{{ $users->lastItem() }}</span> of <span class="font-medium">{{ $users->total() }}</span> users
                        </div>
                        <div class="flex items-center space-x-2">
                            {{ $users->appends(request()->query())->links() }}
                        </div>
                    </div>

                    <!-- Refresh Button -->
                    <div class="mt-6 flex justify-end">
                        <button onclick="location.reload();" type="button" 
                                class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg shadow-md hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Refresh Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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

    // Search and perPage functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const perPageSelect = document.getElementById('perPage');

        let debounceTimeout = null;

        function updateUrl() {
            const params = new URLSearchParams(window.location.search);
            if (searchInput.value) {
                params.set('search', searchInput.value);
            } else {
                params.delete('search');
            }
            params.set('perPage', perPageSelect.value);
            window.location.href = window.location.pathname + '?' + params.toString();
        }

        function debounceSearch() {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(updateUrl, 500); // 500ms delay
        }

        searchInput.addEventListener('input', debounceSearch);
        perPageSelect.addEventListener('change', updateUrl);
    });
</script>