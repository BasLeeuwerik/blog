<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white shadow-sm rounded-lg divide-y">
            <div class="p-6 flex space-x-2">
                <!-- Post Content -->
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-gray-800">{{ $post->user->name }}</span>
                            <small class="ml-2 text-sm text-gray-600">{{ $post->created_at->format('j M Y, H:i') }}</small>
                            @unless ($post->created_at->eq($post->updated_at))
                            <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                            @endunless
                        </div>
                    </div>
                    <p class="mt-4 text-lg text-gray-900">{{ $post->body }}</p>
                </div>
            </div>

            <!-- Comment input form -->
            <div class="p-6">
                <form method="POST" action="{{ route('comments.store', ['post' => $post->id]) }}" class="mt-6">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <textarea name="body" placeholder="{{ __('Add a comment...') }}" class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('body') }}</textarea>
                    <x-input-error :messages="$errors->get('body')" class="mt-2" />
                    <x-primary-button class="mt-4">{{ __('post comment') }}</x-primary-button>
                </form>

                <!-- Display existing comments -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800">{{ __('Comments') }}</h3>
                    @foreach ($post->comments->sortByDesc('created_at') as $comment)
                    <div class="bg-gray-100 p-3 mt-2 rounded-md">
                        <b>{{ $comment->user->name }} commented:</b>
                        <p class="text-gray-800">{{ $comment->body }}</p>
                        <small class="text-sm text-gray-600">{{ $comment->created_at->format('j M Y, H:i') }}</small>
                        <!-- Delete comment button (for comment author only) -->
                        @if ($comment->user->is(auth()->user()))
                        <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                            @csrf
                            @method('delete')
                            <button type="submit" class="text-red-500 hover:text-red-700">delete</button>
                        </form>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
