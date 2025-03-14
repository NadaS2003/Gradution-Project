<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentAssignedToSupervisor extends Notification
{
    use Queueable;

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
            'message' => "تم تعيينك كمشرف للطالبة/الطالب {$this->studentName}.",
            'student_name' => $this->studentName,
        ];
    }
}
