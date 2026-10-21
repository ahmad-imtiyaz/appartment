<?php

namespace App\Notifications;

use App\Models\WorkerPayout;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Dikirim langsung (tanpa queue) supaya tetap terkirim di hosting cPanel
 * tanpa queue worker.
 */
class WorkerPayoutPaidNotification extends Notification
{
    use Queueable;

    public function __construct(
        public WorkerPayout $payout
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $payout = $this->payout->loadMissing('serviceRequest.service');
        $amount = 'Rp' . number_format($payout->amount, 0, ',', '.');

        return (new MailMessage)
            ->subject('Pembayaran Selesai: ' . $amount)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Telah dibayarkan sejumlah ' . $amount . ' untuk tugas ' . $payout->serviceRequest->service->name . ' #' . $payout->service_request_id . '.')
            ->line('Ditransfer ke ' . $payout->bank_name . ' ' . $payout->account_number . ' a.n. ' . $payout->account_holder_name . '.')
            ->when($payout->admin_note, fn ($mail) => $mail->line('Catatan admin: ' . $payout->admin_note))
            ->action('Lihat Bukti Transfer', route('worker.payouts.index'))
            ->line('Terima kasih.');
    }
}
