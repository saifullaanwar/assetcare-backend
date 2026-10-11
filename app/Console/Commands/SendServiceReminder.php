<?php

namespace App\Console\Commands;

use App\Models\MaintenanceLog;
use App\Models\User;
use App\Notifications\ServiceReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendServiceReminder extends Command
{
    /**
     * Nama command yang dijalankan di terminal.
     */
    protected $signature = 'app:send-service-reminder';

    /**
     * Deskripsi command.
     */
    protected $description = 'Memeriksa dan mengirim notifikasi pengingat service aset yang jatuh pada hari ini atau H-3';

    public function handle()
    {
        $this->info('Pemeriksaan jadwal service aset dimulai...');

        $today = Carbon::today()->toDateString();
        $threeDaysLater = Carbon::today()->addDays(3)->toDateString();

        // Cari maintenance log yang next_service_date-nya jatuh hari ini atau H-3
        $logs = MaintenanceLog::with(['asset.category', 'asset.location'])
            ->whereIn('next_service_date', [$today, $threeDaysLater])
            ->get();

        if ($logs->isEmpty()) {
            $this->info('Tidak ada jadwal service aset untuk hari ini atau H-3.');
            return Command::SUCCESS;
        }

        // Ambil semua akun User/Admin sebagai penerima notifikasi
        $users = User::all();

        if ($users->isEmpty()) {
            $this->warn('Tidak ada user/admin terdaftar di sistem untuk menerima email.');
            return Command::FAILURE;
        }

        foreach ($logs as $log) {
            Notification::send($users, new ServiceReminderNotification($log));
            $this->info("Notifikasi pengingat dikirim untuk Aset: {$log->asset->name} (Jadwal: {$log->next_service_date})");
        }

        $this->info('Seluruh notifikasi pengingat service berhasil dikirim!');
        return Command::SUCCESS;
    }
}