@extends('layouts.app')

@section('content')

    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto p-8">


            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">
                    Add New Contact
                </h1>
                <p class="text-gray-600 mt-1">
                    For contact: <span class="font-semibold">{{ $person->name }}</span>
                </p>
            </div>


            <hr class="mb-8">

            <form action="{{ route('contacts.store', $person->id) }}" method="POST">
                @csrf


                @include('contacts._form', ['countries' => $countries])

            </form>
        </div>
    </div>
@endsection
