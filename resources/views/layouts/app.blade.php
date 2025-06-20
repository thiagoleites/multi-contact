<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Manager</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif; /* Using Inter font as per instructions */
            background-color: #f3f4f6; /* Light gray background */
        }
        /* Custom styles for focus rings to match rounded corners */
        :focus {
            outline: 2px solid #6366f1; /* Indigo 500 */
            outline-offset: 2px;
            border-radius: 0.5rem; /* Match Tailwind's rounded-lg */
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
<nav class="bg-indigo-600 p-4 text-white shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ route('people.index') }}" class="text-2xl font-bold rounded-lg hover:bg-indigo-700 px-3 py-2 transition duration-200">Contact Manager</a>
        <div class="space-x-4 flex items-center">
            <a href="{{ route('people.index') }}" class="text-white hover:bg-indigo-700 px-3 py-2 rounded-lg transition duration-200">People List</a>
            <a href="{{ route('reports.contacts-by-country') }}" class="text-white hover:bg-indigo-700 px-3 py-2 rounded-lg transition duration-200">Contacts by Country</a>
            @guest
                <a href="{{ route('login') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200">Login</a>
            @endguest
            @auth
                <a href="{{ route('people.create') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200">Add New Person</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-200">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<main class="container mx-auto mt-8 p-4 flex-grow">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
            <strong class="font-bold">Sucesso!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none';">
                        <title>Fechar</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.103l-2.651 3.746a1.2 1.2 0 1 1-1.697-1.697l3.746-2.651-3.746-2.651a1.2 1.2 0 0 1 1.697-1.697L10 8.897l2.651-3.746a1.2 1.2 0 0 1 1.697 1.697L11.103 10l3.746 2.651a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
            <strong class="font-bold">Erro!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none';">
                        <title>Fechar</title>
                        <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.103l-2.651 3.746a1.2 1.2 0 1 1-1.697-1.697l3.746-2.651-3.746-2.651a1.2 1.2 0 0 1 1.697-1.697L10 8.897l2.651-3.746a1.2 1.2 0 0 1 1.697 1.697L11.103 10l3.746 2.651a1.2 1.2 0 0 1 0 1.698z"/>
                    </svg>
                </span>
        </div>
    @endif

    @yield('content')
</main>

<footer class="bg-indigo-600 p-4 text-white text-center mt-8 shadow-md">
    <div class="container mx-auto">
        &copy; {{ date('Y') }} Multi Contact Manager. All rights reserved.
    </div>
</footer>
</body>
</html>
