<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($logType . ' Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="max-w-8xl mx-auto p-4 sm:p-6 lg:p-8">
                        <div class="bg-white dark:bg-gray-700 shadow-sm rounded-lg divide-y">
                            <ul class="divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse ($logLines as $logLine)
                                    <li class="py-2 px-4 text-sm font-mono bg-gray-100 dark:bg-gray-800 rounded-lg my-1">
                                        {{ $logLine }}
                                    </li>
                                @empty
                                    <li class="py-2 px-4 text-sm font-mono bg-gray-100 dark:bg-gray-800 rounded-lg my-1">
                                        No logs found.
                                    </li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="mt-4 flex justify-between text-sm">
                            @if ($currentPage > 1)
                                <a href="{{ route('logs.show', ['type' => $logType, 'page' => $currentPage - 1]) }}" class="text-blue-500 hover:text-blue-700">
                                    &laquo; Previous
                                </a>
                            @endif
                            @if ($linesPerPage * $currentPage < $totalLines)
                                <a href="{{ route('logs.show', ['type' => $logType, 'page' => $currentPage + 1]) }}" class="text-blue-500 hover:text-blue-700">
                                    Next &raquo;
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
