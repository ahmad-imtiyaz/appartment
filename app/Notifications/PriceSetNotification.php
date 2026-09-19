<?php

namespace App\Notifications;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PriceSetNotification extends Notification implements ShouldQueue
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
        $sr = $this->serviceRequest->loadMissing('service');

        return (new MailMessage)
            ->subject('Harga Perbaikan Sudah Ditetapkan: ' . $sr->service->name)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Admin telah menetapkan harga final untuk permintaan perbaikan kamu.')
            ->line('Total Harga: Rp' . number_format($sr->total_price, 0, ',', '.'))
            ->when($sr->price_change_note, fn ($mail) => $mail->line('Catatan: ' . $sr->price_change_note))
            ->line('Mohon setujui atau tolak harga ini melalui dashboard.')
            ->action('Lihat & Setujui', route('guest.service-requests.show', $sr))
            ->line('Terima kasih.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'service_request_id' => $this->serviceRequest->id,
            'service_name' => $this->serviceRequest->service->name,
            'message' => 'Harga perbaikan sudah ditetapkan: Rp' . number_format($this->serviceRequest->total_price, 0, ',', '.'),
        ];
    }
}
