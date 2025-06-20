@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">People Directory</h1>
                <p class="mt-1 text-sm text-gray-500">Manage all registered individuals in the system.</p>
            </div>
            @auth
                <a href="{{ route('people.create') }}"
                   class="mt-4 sm:mt-0 w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm transition-colors duration-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Person
                </a>
            @endauth
        </div>

        @if ($people->isEmpty())
            {{-- Empty State --}}
            <div class="text-center border-2 border-dashed border-gray-300 p-12 rounded-lg mt-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21v-1a6 6 0 00-5.176-5.97m8.176 5.97v-1c0-3.314-2.686-6-6-6s-6 2.686-6 6v1h12z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No people found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by adding a new person to the directory.</p>
            </div>
        @else
            {{-- People Table --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        {{-- Clean header with a more modern font style --}}
                        <tr class="text-xs font-semibold uppercase tracking-wider text-left text-gray-500">
                            <th scope="col" class="px-6 py-3">Avatar</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="relative px-6 py-3 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm text-gray-700">
                        @foreach ($people as $person)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ $person->avatar_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($person->name) . '&background=e5e7eb&color=4b5563' }}"
                                         alt="{{ $person->name }} Avatar"
                                         class="w-10 h-10 rounded-full object-cover border-2 border-gray-200"
                                         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=N+A&background=e5e7eb&color=4b5563';">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('people.show', $person->id) }}" class="font-medium text-gray-900 hover:text-indigo-600">
                                        {{ $person->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $person->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-3">
                                        {{-- Refined action buttons --}}
                                        <a href="{{ route('people.show', $person->id) }}" class="text-gray-500 hover:text-blue-600" title="See details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @auth
                                            <a href="{{ route('people.edit', $person->id) }}" class="text-gray-500 hover:text-green-600" title="Edit Person">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('people.destroy', $person->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this person?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-500 hover:text-red-600" title="Delete Person">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
