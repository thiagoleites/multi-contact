<div class="mb-4">
    <label for="country_code_input" class="block text-gray-700 text-sm font-bold mb-2">Country:</label>
    <input
        type="text"
        list="country_codes_list"
        id="country_code_input"
        name="country_code"
        value="{{ old('country_code', $contact->country_code ?? '') }}"
        placeholder="Search and select country"
        class="block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
        required
    >
    <datalist id="country_codes_list">
        @foreach($countries as $country)
            <option value="{{ $country['value'] }}">{{ $country['text'] }}</option>
        @endforeach
    </datalist>
    @error('country_code')
    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
    @enderror
    <p class="text-gray-500 text-xs mt-1">Select a country from the list. The country code will be saved.</p>
</div>

<div class="mb-6">
    <label for="number" class="block text-gray-700 text-sm font-bold mb-2">Number (9 digits):</label>
    <input type="text" name="number" id="number" value="{{ old('number', $contact->number ?? '') }}"
           class="block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
           required pattern="\d{9}" title="Number must be exactly 9 digits." maxlength="9" inputmode="numeric">
    @error('number')
    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="flex items-center justify-between">
    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-200 shadow-sm">
        {{ isset($contact) ? 'Update Contact' : 'Add Contact' }}
    </button>
    <a href="{{ route('people.show', $person->id) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-200 shadow-sm">
        Cancel
    </a>
</div>

