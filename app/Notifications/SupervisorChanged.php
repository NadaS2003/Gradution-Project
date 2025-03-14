<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SupervisorChanged extends Notification
{
    protected $oldSupervisorName;

    public function __construct($oldSupervisorName)
    {
        $this->oldSupervisorName = $oldSupervisorName;
    }

    public function via($notifiable)
    {
        return [ 'database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'message' => 'تم تغيير مشرفك إلى ' . $this->oldSupervisorName,
        ];
    }
}
