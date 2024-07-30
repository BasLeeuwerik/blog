<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($logType . ' logs') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="max-w-8xl mx-auto p-4 sm:p-6 lg:p-8">
                        <div class="bg-white shadow-sm rounded-lg divide-y">
                            <ul>
                                @forelse ($logLines as $logLine)
                                    <li>{{ $logLine }}</li>
                                @empty
                                    <li>No logs found.</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="mt-4">
                            @if ($currentPage > 1)
                                <a href="{{ route('logs.show', ['type' => $logType, 'page' => $currentPage - 1]) }}" class="mr-2">Previous</a>
                            @endif
                            @if ($linesPerPage * $currentPage < $totalLines)
                                <a href="{{ route('logs.show', ['type' => $logType, 'page' => $currentPage + 1]) }}">Next</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
