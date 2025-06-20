@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Cabeçalho da Página (Mantido) --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Contacts by Country</h1>
            <p class="mt-1 text-sm text-gray-500">A summary report of all contacts aggregated by their country.</p>
        </div>

        @if ($reportData->isEmpty())
            {{-- Estado Vazio (Mantido) --}}
            <div class="text-center border-2 border-dashed border-gray-300 p-12 rounded-lg mt-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No report data</h3>
                <p class="mt-1 text-sm text-gray-500">There are no contacts with associated countries to generate a report.</p>
            </div>
        @else
            {{-- Container da Tabela Aprimorada --}}
            <div class="bg-white overflow-hidden shadow-md rounded-lg border border-gray-200/75">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        {{-- Cabeçalho da Tabela --}}
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr class="text-xs font-bold uppercase tracking-wider text-left text-gray-600">
                            <th scope="col" class="px-6 py-4">Country</th>
                            <th scope="col" class="px-6 py-4">Country Code</th>
                            <th scope="col" class="px-6 py-4 text-center">Total Contacts</th>
                        </tr>
                        </thead>
                        {{-- Corpo da Tabela --}}
                        <tbody class="divide-y divide-gray-200/50">
                        @foreach ($reportData as $item)
                            {{-- Linha da Tabela com hover sutil --}}
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">

                                {{-- Célula do País com Ícone --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        {{-- Ícone de Globo Sutil --}}
                                        <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A11.953 11.953 0 0112 13.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0l-4.5-4.5" />
                                        </svg>
                                        <span class="font-medium text-gray-800">{{ $item['country_name'] }}</span>
                                    </div>
                                </td>

                                {{-- Célula do Código do País --}}
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500 font-mono">
                                    +{{ $item['country_code'] }}
                                </td>

                                {{-- Célula do Total de Contatos --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <span class="font-bold text-lg text-indigo-600">{{ $item['total_contacts'] }}</span>
                                        <svg class="h-5 w-5 text-indigo-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0019 16v1h-6.07zM6 11a5 5 0 00-4.54 2.93A6.97 6.97 0 006 16v1H1v-1a5 5 0 015-5z" />
                                        </svg>
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
