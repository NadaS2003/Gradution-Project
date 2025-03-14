<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StudentChangedSupervisor extends Notification
{
    protected $studentName;

    public function __construct($studentName)
    {
        $this->studentName = $studentName;
    }

    public function via($notifiable)
    {
        return ['database'];
    }



    public function toDatabase($notifiable)
    {
        return [
            'message' => 'تم تغيير مشرف الطالب ' . $this->studentName,
        ];
    }
}
