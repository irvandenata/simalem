<?php

namespace App\Notifications;

use App\Models\ReportProblem;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($reportId)
    {
        $this->reportId = $reportId;
        $this->report = ReportProblem::find($reportId);
        $this->link = route('admin.report-problems.show', $reportId);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'data' => 'Ada laporan baru dari ' . $this->report->item->hospital,
            'link' => $this->link,
            'title'=> 'Laporan Masalah Alat'
        ];
    }
}
