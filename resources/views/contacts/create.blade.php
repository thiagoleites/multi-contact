@extends('layouts.app')

@section('content')
    {{-- Fundo cinza claro para destacar o card branco --}}
    <div class="bg-gray-50 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-lg">

            {{-- Cabeçalho redesenhado para melhor hierarquia visual --}}
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">
                    Add New Contact
                </h1>
                <p class="text-gray-600 mt-1">
                    For contact: <span class="font-semibold">{{ $person->name }}</span>
                </p>
            </div>

            {{-- Divisor visual --}}
            <hr class="mb-8">

            <form action="{{ route('contacts.store', $person->id) }}" method="POST">
                @csrf

                {{-- O formulário real será incluído aqui, com as variáveis necessárias --}}
                @include('contacts._form', ['countries' => $countries])

            </form>
        </div>
    </div>
@endsection
