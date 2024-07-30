<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ 'Jobs' }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6">Featured Jobs</h3>
                    <div class="grid gap-6 mb-8 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($featuredJobs as $job)
                            <div class="max-w-md p-4 bg-white rounded-lg shadow-md dark:bg-gray-700">
                                <h4 class="text-xl font-semibold mb-2">{{ $job->title }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $job->employer->name }}</p>
                                <p class="text-sm mb-2">Location: {{ $job->location }}</p>
                                <p class="text-sm mb-2">Salary: {{ $job->salary }}</p>
                                <p class="text-sm mb-2">Schedule: {{ $job->schedule }}</p>
                                <a href="{{ $job->url }}" class="text-blue-500 dark:text-blue-300 hover:underline">Apply Now</a>
                                <div class="mt-4">
                                    @foreach ($job->tags as $tag)
                                        <span class="inline-block bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded-full dark:bg-gray-600 dark:text-gray-200 mr-2">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <h3 class="text-2xl font-bold mb-6">All Jobs</h3>
                    <div class="grid gap-6 mb-8 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($jobs as $job)
                            <div class="max-w-md p-4 bg-white rounded-lg shadow-md dark:bg-gray-700">
                                <h4 class="text-xl font-semibold mb-2">{{ $job->title }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $job->employer->name }}</p>
                                <p class="text-sm mb-2">Location: {{ $job->location }}</p>
                                <p class="text-sm mb-2">Salary: {{ $job->salary }}</p>
                                <p class="text-sm mb-2">Schedule: {{ $job->schedule }}</p>
                                <a href="{{ $job->url }}" class="text-blue-500 dark:text-blue-300 hover:underline">Apply Now</a>
                                <div class="mt-4">
                                    @foreach ($job->tags as $tag)
                                        <span class="inline-block bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded-full dark:bg-gray-600 dark:text-gray-200 mr-2">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
