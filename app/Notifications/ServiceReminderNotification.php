<?php

namespace App\Notifications;

use App\Models\MaintenanceLog;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ServiceReminderNotification extends Notification
{
    use Queueable;

    protected $maintenanceLog;

    public function __construct(MaintenanceLog $maintenanceLog)
    {
        $this->maintenanceLog = $maintenanceLog;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $asset = $this->maintenanceLog->asset;

        return (new MailMessage)
                    ->subject('[AssetCare] Peringatan Jadwal Service Aset: ' . $asset->name)
                    ->greeting('Halo Admin,')
                    ->line('Ini adalah pengingat otomatis untuk perawatan/service aset berikut:')
                    ->line('• Nama Aset: ' . $asset->name)
                    ->line('• Kode Aset: ' . $asset->asset_code)
                    ->line('• Lokasi: ' . ($asset->location->name ?? '-'))
                    ->line('• Tanggal Service Berikutnya: ' . $this->maintenanceLog->next_service_date)
                    ->line('• Catatan Terakhir: ' . ($this->maintenanceLog->notes ?? '-'))
                    ->action('Lihat Portal AssetCare', url('/'))
                    ->line('Harap segera melakukan koordinasi dengan tim teknisi/vendor terkait.');
    }
}