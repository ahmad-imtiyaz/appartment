<?php

namespace App\Notifications;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public ServiceRequest $serviceRequest
    ) {}

    /**
     * Channel notifikasi. 'mail' = email (via Laravel Mail/SMTP).
     * Tambah 'database' di sini kalau nanti mau ada bell notification di dashboard pekerja.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $sr = $this->serviceRequest->loadMissing(['service', 'user']);

        return (new MailMessage)
            ->subject('Tugas Baru: ' . $sr->service->name)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Kamu mendapatkan tugas baru dari admin.')
            ->line('Jenis Jasa: ' . $sr->service->name)
            ->line('Unit/Guest: ' . ($sr->user->apartment_unit_number ?? '-') . ' (' . $sr->user->name . ')')
            ->when($sr->notes, fn ($mail) => $mail->line('Catatan Guest: ' . $sr->notes))
            ->line('Mohon konfirmasi (ACC) tugas ini melalui dashboard pekerja.')
            ->action('Lihat & ACC Tugas', url('/pekerja/tasks/' . $sr->id))
            ->line('Terima kasih.');
    }

    /**
     * Dipakai kalau nanti channel 'database' diaktifkan (opsional).
     */
    public function toArray(object $notifiable): array
    {
        return [
            'service_request_id' => $this->serviceRequest->id,
            'service_name' => $this->serviceRequest->service->name,
            'message' => 'Kamu mendapatkan tugas baru: ' . $this->serviceRequest->service->name,
        ];
    }
}
