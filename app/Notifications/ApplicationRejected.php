<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class ApplicationRejected extends Notification
{
    private $internshipTitle;

    public function __construct($internshipTitle)
    {
        $this->internshipTitle = $internshipTitle;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'تم رفض طلبك للتدريب في ' . $this->internshipTitle,
        ];
    }
}
