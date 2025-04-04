<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InternshipApplicationNotification extends Notification
{
    use Queueable;



    public function __construct()
    {

    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "طلب تدريب جديد.",
            'url' => route('company.trainingRequests'),
        ];
    }
}
