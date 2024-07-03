<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewPost extends Notification
{
    use Queueable;

    public function __construct(public Post $post)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject("New Post from {$this->post->user->name}")
            ->greeting("New Post from {$this->post->user->name}")
            ->line(Str::limit($this->post->message, 50))
            ->action("Go to Post", url('/posts/' . $this->post->id));

        Log::channel('email')->info('Email content: ', $mailMessage->toArray());

        return $mailMessage;
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
