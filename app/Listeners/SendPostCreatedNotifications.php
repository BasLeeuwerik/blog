<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Notifications\NewPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;

class SendPostCreatedNotifications implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(PostCreated $event): void
    {
        foreach (User::whereNot('id', $event->post->user_id)->cursor() as $user) {
            $user->notify(new NewPost($event->post));
        }
    }
}
