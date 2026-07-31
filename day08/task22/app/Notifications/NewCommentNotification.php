<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Comment $comment
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Нов коментар по задача')
            ->line('Добавен е нов коментар към задача: ' . $this->comment->task->title)
            ->line('Коментарът е от: ' . $this->comment->user->name)
            ->action(
                'Виж задачата',
                url('/tasks/' . $this->comment->task->id)
            );
    }
}