<?php

namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;


class InternshipApprovalNotification extends Notification
{
    use Queueable;

    protected $student;
    protected $company;
    protected $application;

    public function __construct($student, $company, $application)
    {
        $this->student = $student;
        $this->company = $company;
        $this->application = $application;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "يحتاج طلب الطالب {$this->student->full_name}  إلى موافقتك.",
            'application_id' => $this->application->id,
            'company_name' => $this->company->company_name
        ];
    }
}
