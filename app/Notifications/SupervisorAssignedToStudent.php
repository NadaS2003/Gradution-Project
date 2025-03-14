<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SupervisorAssignedToStudent extends Notification
{
    use Queueable;

    protected $supervisorName;

    public function __construct($supervisorName)
    {
        $this->supervisorName = $supervisorName;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "تم تعيين المشرف {$this->supervisorName} لإشرافك.",
            'supervisor_name' => $this->supervisorName,
        ];
    }
}
