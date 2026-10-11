<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Menjalankan scheduler pengingat service setiap hari jam 08:00 pagi
Schedule::command('app:send-service-reminder')->dailyAt('08:00');