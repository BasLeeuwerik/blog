<?php

namespace App\Listeners;

use App\Events\PostCreated;
use App\Notifications\NewPost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class SendPostCreatedNotifications implements ShouldQueue
{
    public function handle(PostCreated $event): void
    {
        Log::channel('info')->info("User {$event->post->user_id} created a new post.");

        foreach (User::whereNot('id', $event->post->user_id)->cursor() as $user) {
            $user->notify(new NewPost($event->post));
        }

        Log::channel('info')->info("Email notifications for new post {$event->post->id} were sent successfully.");
    }
}
