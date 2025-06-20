@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-8">
        <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-200">
            <h1 class="text-4xl font-extrabold text-gray-800 flex items-center">
                <img src="{{ $person->avatar_url ?: 'https://placehold.co/80x80/cccccc/333333?text=No+Img' }}"
                     alt="{{ $person->name }} Avatar"
                     class="w-20 h-20 rounded-full object-cover mr-4 border-4 border-indigo-400 shadow-md"
                     onerror="this.onerror=null;this.src='https://placehold.co/80x80/cccccc/333333?text=No+Img';">
                {{ $person->name }}
            </h1>
            @auth {{-- Apenas para usuários autenticados --}}
            <div class="flex space-x-3">
                <a href="{{ route('people.edit', $person->id) }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-5 rounded-lg shadow-sm transition duration-200 flex items-center">
                    <i class="fas fa-edit mr-2"></i> Edit Person
                </a>
                <form action="{{ route('people.destroy', $person->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja apagar (soft delete) esta pessoa e todos os seus contatos?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-5 rounded-lg shadow-sm transition duration-200 flex items-center">
                        <i class="fas fa-trash-alt mr-2"></i> Delete Person
                    </button>
                </form>
            </div>
            @endauth
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-700 mb-4">Personal information</h2>
                <p class="text-gray-700 mb-2"><strong class="font-semibold text-gray-900">ID:</strong> {{ $person->id }}</p>
                <p class="text-gray-700 mb-2"><strong class="font-semibold text-gray-900">Email:</strong> {{ $person->email }}</p>
                <p class="text-gray-700 mb-2"><strong class="font-semibold text-gray-900">Created:</strong> {{ $person->created_at ? $person->created_at->format('M d, Y H:i A') : 'N/A' }}</p>
                <p class="text-gray-700"><strong class="font-semibold text-gray-900">Last update:</strong> {{ $person->updated_at->format('M d, Y H:i A') }}</p>
            </div>
            <div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-2xl font-bold text-gray-700 mb-4">About avagar</h2>
                <p class="text-gray-700 mb-2">The avatar is a randomly generated monster image from <a href="https://app.pixelencounter.com" target="_blank" class="text-indigo-600 hover:underline">PixelEncounter API</a>.</p>
                <p class="text-700">It provides a unique visual identifier for each person.</p>
                <p class="text-gray-700 mt-2">Avatar URL: <span class="break-all text-sm text-gray-600">{{ $person->avatar_url ?: 'N/A' }}</span></p>
            </div>
        </div>

        <div class="flex justify-between items-center mb-6 pt-4 border-t border-gray-200">
            <h2 class="text-2xl font-bold text-gray-700">Contacts</h2>
            @auth {{-- Apenas para usuários autenticados --}}
            <a href="{{ route('contacts.create', $person->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-5 rounded-lg shadow-sm transition duration-200 flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Add new Contact
            </a>
            @endauth
        </div>

        @if ($person->contacts->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-600 text-lg">
                    No contacts found for this person. Add one now
                </p>
                <img src="https://placehold.co/300x150/edf2f7/4a5568?text=No+Contacts" alt="Nenhum contato placeholder" class="mx-auto mt-4 rounded-lg shadow-sm">
            </div>
        @else
            <div class="overflow-x-auto rounded-lg shadow-sm">
                <table class="min-w-full leading-normal">
                    <thead>
                    <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left rounded-tl-lg">Country code</th>
                        <th class="py-3 px-6 text-left">Number</th>
                        <th class="py-3 px-6 text-center rounded-tr-lg">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                    @foreach ($person->contacts as $contact)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">+{{ $contact->country_code }}</td>
                            <td class="py-3 px-6 text-left">{{ $contact->number }}</td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-3">
                                    @auth {{-- Loged users --}}
                                    <a href="{{ route('contacts.edit', ['person' => $person->id, 'contact' => $contact->id]) }}" class="w-8 h-8 rounded-full bg-green-100 hover:bg-green-200 text-green-600 flex items-center justify-center transition duration-200" title="Edit Contact">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <form action="{{ route('contacts.destroy', ['person' => $person->id, 'contact' => $contact->id]) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-full bg-red-100 hover:bg-red-200 text-red-600 flex items-center justify-center transition duration-200" title="Delete Contact">
                                            <i class="fas fa-trash-alt text-sm"></i>
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
        @endif
    </div>
@endsection

