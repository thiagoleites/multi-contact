@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-8">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-6 text-center">Add New Person</h1>

        <form action="{{ route('people.store') }}" method="POST">
            @csrf
            @include('people._form') {{-- Include the shared form partial --}}
        </form>
    </div>
@endsection

