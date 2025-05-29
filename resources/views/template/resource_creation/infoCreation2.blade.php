<x-app-layout>
<div class="max-w-4xl mx-auto p-4 space-y-6">
    <!-- Labels -->
    <div class="bg-white p-4 rounded-lg shadow">
        <label class="block mb-2 font-semibold text-gray-700">Labels</label>
        <div id="labels" class="space-y-4">
            <button type="button" class="bg-gray-800 text-white px-3 py-1 rounded hover:bg-gray-700" onClick="appendInput('labels', 'key_labels[]')">+ Add Label</button>
            @if(old('key_labels'))
                @foreach(old('key_labels') as $index => $key)
                    <div class="flex items-center space-x-2 bg-gray-50 p-3 rounded-lg border border-gray-200">
                        <!-- Key -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="key_labels[{{ $index }}]">Key</label>
                            <input 
                                type="text" 
                                name="key_labels[]" 
                                id="key_labels[{{ $index }}]" 
                                value="{{ $key }}" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('key_labels.'.$index) border-red-500 @enderror" />
                        </div>
                        <!-- Value -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="value_labels[{{ $index }}]">Value</label>
                            <input 
                                type="text" 
                                name="value_labels[]" 
                                id="value_labels[{{ $index }}]" 
                                value="{{ old('value_labels')[$index] ?? '' }}" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('value_labels.'.$index) border-red-500 @enderror" />
                        </div>
                        <!-- Remove Button -->
                        <button type="button" class="text-red-600 hover:bg-red-100 p-2 rounded-full" onclick="removeInput(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 3a1 1 0 00-1 1v1H4a1 1 0 000 2h12a1 1 0 100-2h-1V4a1 1 0 00-1-1H6zm2 7a.75.75 0 00-.75.75v5.5a.75.75 0 001.5 0v-5.5A.75.75 0 008 10zm4 0a.75.75 0 00-.75.75v5.5a.75.75 0 001.5 0v-5.5A.75.75 0 0012 10z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Annotations -->
    <div class="bg-white p-4 rounded-lg shadow">
        <label class="block mb-2 font-semibold text-gray-700">Annotations</label>
        <div id="annotations" class="space-y-4">
            <button type="button" class="bg-gray-800 text-white px-3 py-1 rounded hover:bg-gray-700" onClick="appendInput('annotations', 'key_annotations[]')">+ Add Annotation</button>
            @if(old('key_annotations'))
                @foreach(old('key_annotations') as $index => $key)
                    <div class="flex items-center space-x-2 bg-gray-50 p-3 rounded-lg border border-gray-200">
                        <!-- Key -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="key_annotations[{{ $index }}]">Key</label>
                            <input 
                                type="text" 
                                name="key_annotations[]" 
                                id="key_annotations[{{ $index }}]" 
                                value="{{ $key }}" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('key_annotations.'.$index) border-red-500 @enderror" />
                        </div>
                        <!-- Value -->
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="value_annotations[{{ $index }}]">Value</label>
                            <input 
                                type="text" 
                                name="value_annotations[]" 
                                id="value_annotations[{{ $index }}]" 
                                value="{{ old('value_annotations')[$index] ?? '' }}" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('value_annotations.'.$index) border-red-500 @enderror" />
                        </div>
                        <!-- Remove Button -->
                        <button type="button" class="text-red-600 hover:bg-red-100 p-2 rounded-full" onclick="removeInput(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 3a1 1 0 00-1 1v1H4a1 1 0 000 2h12a1 1 0 100-2h-1V4a1 1 0 00-1-1H6zm2 7a.75.75 0 00-.75.75v5.5a.75.75 0 001.5 0v-5.5A.75.75 0 008 10zm4 0a.75.75 0 00-.75.75v5.5a.75.75 0 001.5 0v-5.5A.75.75 0 0012 10z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<!-- Scripts para manipulação dinâmica -->
<script>
    function appendInput(containerId, keyName) {
        const container = document.getElementById(containerId);
        const index = container.children.length;

        // Crie o elemento principal
        const div = document.createElement('div');
        div.className = 'flex items-center space-x-2 bg-gray-50 p-3 rounded-lg border border-gray-200';

        // Key input
        const keyDiv = document.createElement('div');
        keyDiv.className = 'flex-1';
        keyDiv.innerHTML = `
            <label class="block text-sm font-medium text-gray-700 mb-1" for="${keyName}[${index}]">Key</label>
            <input type="text" name="${keyName}" id="${keyName}[${index}]" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        `;

        // Value input
        const valueDiv = document.createElement('div');
        valueDiv.className = 'flex-1';
        valueDiv.innerHTML = `
            <label class="block text-sm font-medium text-gray-700 mb-1" for="value_${keyName}[${index}]">Value</label>
            <input type="text" name="value_${keyName}" id="value_${keyName}[${index}]" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        `;

        // Remove button
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'text-red-600 hover:bg-red-100 p-2 rounded-full';
        removeBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 3a1 1 0 00-1 1v1H4a1 1 0 000 2h12a1 1 0 100-2h-1V4a1 1 0 00-1-1H6zm2 7a.75.75 0 00-.75.75v5.5a.75.75 0 001.5 0v-5.5A.75.75 0 008 10zm4 0a.75.75 0 00-.75.75v5.5a.75.75 0 001.5 0v-5.5A.75.75 0 0012 10z" clip-rule="evenodd" />
            </svg>
        `;
        removeBtn.onclick = function() { removeInput(removeBtn); };

        // Append tudo ao div principal
        div.appendChild(keyDiv);
        div.appendChild(valueDiv);
        div.appendChild(removeBtn);

        container.appendChild(div);
    }

    function removeInput(element) {
        element.closest('.flex.items-center.space-x-2').remove();
    }
</script>
</x-app-layout>