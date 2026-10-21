<?php

namespace App\Notifications;

use App\Models\ServiceRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Dikirim langsung (tanpa queue), sama seperti email kode reset password,
 * supaya tetap terkirim di hosting cPanel tanpa queue worker.
 */
class ServiceRequestRejectedNotification extends Notification
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
        $reason = __('guest.cancel_reasons.' . $sr->cancel_reason, [], 'id');

        return (new MailMessage)
            ->subject('Pesanan Ditolak: ' . $sr->service->name)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Mohon maaf, permintaan "' . $sr->service->name . '" kamu (Order #' . str_pad($sr->id, 7, '0', STR_PAD_LEFT) . ') ditolak oleh admin.')
            ->line('Alasan: ' . $reason)
            ->line('Silakan ajukan permintaan baru di lain waktu.')
            ->action('Lihat Pesanan', route('guest.service-requests.show', $sr))
            ->line('Terima kasih.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'service_request_id' => $this->serviceRequest->id,
            'service_name' => $this->serviceRequest->service->name,
            'message' => 'Permintaan "' . $this->serviceRequest->service->name . '" ditolak admin: ' . __('guest.cancel_reasons.' . $this->serviceRequest->cancel_reason, [], 'id'),
        ];
    }
}
