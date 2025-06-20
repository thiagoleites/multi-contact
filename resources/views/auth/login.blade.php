@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 flex items-center justify-center mt-20">

        <div class="w-full max-w-md p-8  space-y-6">

            {{-- Form Header --}}
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900">Sign In</h1>
                <p class="mt-2 text-sm text-gray-600">Welcome back! Please enter your details.</p>
            </div>

            {{-- Error Alert --}}
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Email Input --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                              @error('email') border-red-500 ring-red-500 @enderror"
                           placeholder="you@example.com" required autofocus>
                    @error('email')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Input --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password"
                           class="block w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md placeholder-gray-400
                              focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500
                              @error('password') border-red-500 ring-red-500 @enderror"
                           required>
                    @error('password')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col space-y-4 pt-2">
                    <button type="submit"
                            class="w-full bg-indigo-600 text-white font-bold py-2.5 px-4 rounded-md
                               hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                               transition-colors duration-300 ease-in-out shadow-sm">
                        Login
                    </button>
                    <a href="{{ route('people.index') }}"
                       class="w-full text-center bg-white text-gray-700 font-bold py-2.5 px-4 rounded-md
                          border border-gray-300 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300
                          transition-colors duration-300 ease-in-out shadow-sm">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
