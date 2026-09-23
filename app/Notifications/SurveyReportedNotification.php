<?php

namespace App\Notifications;

use App\Models\RepairPricing;
use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SurveyReportedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public ServiceRequest $serviceRequest
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $sr = $this->serviceRequest->loadMissing(['service', 'user', 'worker', 'maintenanceDetail']);
        $detail = $sr->maintenanceDetail; // null untuk AC repair/full-service

        $mail = (new MailMessage)
            ->subject('Survey Selesai: ' . $sr->service->name)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Pekerja telah menyelesaikan survey untuk permintaan "' . $sr->service->name . '" berikut.')
            ->line('Unit/Guest: ' . ($sr->user->apartment_unit_number ?? '-') . ' (' . $sr->user->name . ')')
            ->line('Pekerja: ' . ($sr->worker->name ?? '-'));

        if ($detail) {
            $mail = $mail
                ->line('Kategori Kerusakan: ' . (RepairPricing::CATEGORIES[$detail->damage_category] ?? 'Lainnya'))
                ->line('Tingkat Kerusakan: ' . $detail->severityLabel());
        }

        return $mail
            ->when($sr->survey_notes, fn ($m) => $m->line('Catatan Survey: ' . $sr->survey_notes))
            ->line('Mohon tetapkan harga final untuk permintaan ini.')
            ->action('Set Harga', route('admin.service-requests.show', $sr))
            ->line('Terima kasih.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'service_request_id' => $this->serviceRequest->id,
            'service_name' => $this->serviceRequest->service->name,
            'message' => 'Survey selesai untuk permintaan "' . $this->serviceRequest->service->name . '" #' . $this->serviceRequest->id . ', harga perlu ditetapkan.',
        ];
    }
}
