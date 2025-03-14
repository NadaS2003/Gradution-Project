<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationAccepted extends Notification
{
    use Queueable;


    private $internshipTitle;

    public function __construct($internshipTitle)
    {
        $this->internshipTitle = $internshipTitle;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'تم قبول طلبك للفرصة التدريبية: ' . $this->internshipTitle,
            'internship_title' => $this->internshipTitle,
        ];
    }
    public function acceptApplication($applicationId)
    {

        $application = Application::find($applicationId);

        if (!$application) {
            return response()->json(['success' => false, 'message' => 'الطلب غير موجود']);
        }

        $application->status = 'مقبول';
        $application->save();

        $application->student->notify(new ApplicationAccepted($application->internship->title));

        return response()->json(['success' => true, 'message' => 'تم قبول الطلب وإرسال الإشعار']);
    }

    public function toMail(object $notifiable): MailMessage
    {

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
