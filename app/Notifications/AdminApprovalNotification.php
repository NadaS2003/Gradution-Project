<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class AdminApprovalNotification extends Notification
{
    use Queueable;

    protected $internshipTitle;
    protected $status;

    public function __construct($internshipTitle, $status)
    {
        $this->internshipTitle = $internshipTitle;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $message = $this->status == 1
            ? "تمت الموافقة على طلبك في الفرصة التدريبية ({$this->internshipTitle}) من قبل الإدارة."
            : "تم رفض طلبك في الفرصة التدريبية ({$this->internshipTitle}) من قبل الإدارة.";

        return [
            'message' => $message,
            'internship_title' => $this->internshipTitle,
            'status' => $this->status
        ];
    }
}
