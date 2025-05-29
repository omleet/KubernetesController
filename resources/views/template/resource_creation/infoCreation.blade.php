<!-- Labels Section -->
<div class="space-y-6">
    <div>
        <div class="flex items-center justify-between mb-3">
            <div>
                <h4 class="text-base font-medium text-gray-900">Labels</h4>
                <p class="text-sm text-gray-500 mt-1">Add key-value pairs to organize and select your resources</p>
            </div>
            <button type="button" 
                    class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                    onClick="appendLabelInput()">
                <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Add Label
            </button>
        </div>
        
        <div id="labels" class="space-y-3">
            @if(old('key_labels'))
                @foreach(old('key_labels') as $index => $key)
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-start bg-white p-3 rounded-lg border border-gray-200 shadow-sm">
                    <div class="md:col-span-5">
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" 
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg @error("key_labels.{$index}") border-red-500 @enderror" 
                                   name="key_labels[]" 
                                   placeholder="app"
                                   value="{{ $key }}">
                            @error("key_labels.{$index}")
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="md:col-span-5">
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" 
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg @error("value_labels.{$index}") border-red-500 @enderror" 
                                   name="value_labels[]" 
                                   placeholder="frontend"
                                   value="{{ old('value_labels')[$index] }}">
                            @error("value_labels.{$index}")
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="md:col-span-2 flex justify-center pt-1">
                        <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-4 text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-200 border-dashed">
                    <p>No labels added yet</p>
                    <p class="mt-1">Click "Add Label" to create key-value pairs</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Annotations Section -->
    <div>
        <div class="flex items-center justify-between mb-3">
            <div>
                <h4 class="text-base font-medium text-gray-900">Annotations</h4>
                <p class="text-sm text-gray-500 mt-1">Add non-identifying metadata to resources</p>
            </div>
            <button type="button" 
                    class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                    onClick="appendAnnotationInput()">
                <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Add Annotation
            </button>
        </div>
        
        <div id="annotations" class="space-y-3">
            @if(old('key_annotations'))
                @foreach(old('key_annotations') as $index => $key)
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-start bg-white p-3 rounded-lg border border-gray-200 shadow-sm">
                    <div class="md:col-span-5">
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v-1l1-1 1-1-.257-.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" 
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg @error("key_annotations.{$index}") border-red-500 @enderror" 
                                   name="key_annotations[]" 
                                   placeholder="kubernetes.io/description"
                                   value="{{ $key }}">
                            @error("key_annotations.{$index}")
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="md:col-span-5">
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" 
                                   class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg @error("value_annotations.{$index}") border-red-500 @enderror" 
                                   name="value_annotations[]" 
                                   placeholder="Development namespace"
                                   value="{{ old('value_annotations')[$index] }}">
                            @error("value_annotations.{$index}")
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="md:col-span-2 flex justify-center pt-1">
                        <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-4 text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-200 border-dashed">
                    <p>No annotations added yet</p>
                    <p class="mt-1">Click "Add Annotation" to create key-value pairs</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Function to append new label input pair
    function appendLabelInput() {
        const container = document.getElementById('labels');
        
        // Remove the empty state message if it exists
        const emptyState = container.querySelector('.text-center.py-4');
        if (emptyState) {
            emptyState.remove();
        }
        
        const newInput = document.createElement('div');
        newInput.className = 'grid grid-cols-1 md:grid-cols-12 gap-3 items-start bg-white p-3 rounded-lg border border-gray-200 shadow-sm';
        newInput.innerHTML = `
            <div class="md:col-span-5">
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" 
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg" 
                           name="key_labels[]"
                           placeholder="app">
                </div>
            </div>
            <div class="md:col-span-5">
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" 
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg" 
                           name="value_labels[]"
                           placeholder="frontend">
                </div>
            </div>
            <div class="md:col-span-2 flex justify-center pt-1">
                <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        `;
        container.appendChild(newInput);
    }

    // Function to append new annotation input pair
    function appendAnnotationInput() {
        const container = document.getElementById('annotations');
        
        // Remove the empty state message if it exists
        const emptyState = container.querySelector('.text-center.py-4');
        if (emptyState) {
            emptyState.remove();
        }
        
        const newInput = document.createElement('div');
        newInput.className = 'grid grid-cols-1 md:grid-cols-12 gap-3 items-start bg-white p-3 rounded-lg border border-gray-200 shadow-sm';
        newInput.innerHTML = `
            <div class="md:col-span-5">
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v-1l1-1 1-1-.257-.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" 
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg" 
                           name="key_annotations[]"
                           placeholder="kubernetes.io/description">
                </div>
            </div>
            <div class="md:col-span-5">
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" 
                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg" 
                           name="value_annotations[]"
                           placeholder="Development namespace">
                </div>
            </div>
            <div class="md:col-span-2 flex justify-center pt-1">
                <button type="button" class="removeInput text-red-600 hover:text-red-900 p-1 hover:bg-red-50 rounded-full transition-colors duration-200">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        `;
        container.appendChild(newInput);
    }

    // Event delegation for remove buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('removeInput') || e.target.closest('.removeInput')) {
            const button = e.target.classList.contains('removeInput') ? e.target : e.target.closest('.removeInput');
            const gridElement = button.closest('.grid');
            const container = gridElement.parentElement;
            
            gridElement.remove();
            
            // If there are no more inputs, add the empty state message back
            if (container.id === 'labels' && container.querySelectorAll('.grid').length === 0) {
                const emptyState = document.createElement('div');
                emptyState.className = 'text-center py-4 text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-200 border-dashed';
                emptyState.innerHTML = `
                    <p>No labels added yet</p>
                    <p class="mt-1">Click "Add Label" to create key-value pairs</p>
                `;
                container.appendChild(emptyState);
            } else if (container.id === 'annotations' && container.querySelectorAll('.grid').length === 0) {
                const emptyState = document.createElement('div');
                emptyState.className = 'text-center py-4 text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-200 border-dashed';
                emptyState.innerHTML = `
                    <p>No annotations added yet</p>
                    <p class="mt-1">Click "Add Annotation" to create key-value pairs</p>
                `;
                container.appendChild(emptyState);
            }
        }
    });
</script>