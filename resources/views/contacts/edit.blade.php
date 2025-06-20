@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-xl">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-6 text-center">Edit Contact for {{ $person->name }}</h1>

        <form action="{{ route('contacts.update', ['person' => $person->id, 'contact' => $contact->id]) }}" method="POST">
            @csrf
            @method('PUT') {{-- Use PUT method for update operations --}}
            @include('contacts._form', ['person' => $person, 'contact' => $contact, 'countries' => $countries]) {{-- Pass all necessary data --}}
        </form>
    </div>
@endsection

