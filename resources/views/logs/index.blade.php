<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ucfirst($type) }} Logs
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="max-w-8xl mx-auto p-4 sm:p-6 lg:p-8">
                        <div class="bg-white dark:bg-gray-700 shadow-sm rounded-lg divide-y">
                            <!-- Display error message if it exists -->
                            @if (session('error'))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                    <strong class="font-bold">{{ session('error') }}</strong>
                                </div>
                            @endif

                            <ul class="divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse ($logLines as $logLine)
                                    <li class="py-2 px-4 text-sm font-mono bg-gray-100 dark:bg-gray-800 rounded-lg my-1">
                                        {!! nl2br(e($logLine)) !!}
                                    </li>
                                @empty
                                    <li class="py-2 px-4 text-sm font-mono bg-gray-100 dark:bg-gray-800 rounded-lg my-1">
                                        No {{ $type }} logs found.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
