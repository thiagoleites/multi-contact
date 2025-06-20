<div class="mb-4">
    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
    <input type="text" name="name" id="name" value="{{ old('name', $person->name ?? '') }}"
           class="block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
           required minlength="5">
    @error('name')
    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-6">
    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email address:</label>
    <input type="email" name="email" id="email" value="{{ old('email', $person->email ?? '') }}"
           class="block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror"
           required>
    @error('email')
    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="flex items-center justify-between">
    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-200 shadow-md">
        {{ isset($person) ? 'Update People' : 'Add People' }}
    </button>
    <a href="{{ route('people.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-200 shadow-md">
        Cancel
    </a>
</div>

