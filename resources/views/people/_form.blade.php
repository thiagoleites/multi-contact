@extends('layouts.app')

@section('content')


    <!-- Form container for better presentation (e.g., on a page with a different background) -->
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-lg mx-auto">

        <!-- Form Title -->
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
            {{ isset($person) ? 'Edit Person' : 'Add New Person' }}
        </h2>

        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $person->name ?? '') }}"
                   class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200"
                   required minlength="5">
            @error('name')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="mb-6">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address:</label>
            <input type="email" name="email" id="email" value="{{ old('email', $person->email ?? '') }}"
                   class="w-full px-4 py-2 mt-1 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200"
                   required>
            @error('email')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex items-center justify-end space-x-4">
            <!-- Cancel Button (Secondary Action) -->
            <a href="{{ route('people.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition-colors duration-200 shadow-sm">
                Cancel
            </a>
            <!-- Submit Button (Primary Action) -->
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 shadow-md">
                {{ isset($person) ? 'Update Person' : 'Add Person' }}
            </button>
        </div>

    </div>
@endsection
