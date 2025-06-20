@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-8">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-6 text-center">Edit Person</h1>

        <form action="{{ route('people.update', $person->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- Use PUT method for update operations --}}
            @include('people._form', ['person' => $person]) {{-- Pass the person object to the form partial --}}
        </form>
    </div>
@endsection

