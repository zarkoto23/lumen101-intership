<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification
{
    use Queueable;


    public function __construct(
        public Task $task
    ) {}


    public function via(object $notifiable): array
    {
        return [
            'mail'
        ];
    }


    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Нова задача ви е възложена')
            ->line('Имате нова задача: ' . $this->task->title)
            ->line('Проект: ' . $this->task->project->name)
            ->action(
                'Виж задача',
                url('/tasks/' . $this->task->id)
            );
    }
}
