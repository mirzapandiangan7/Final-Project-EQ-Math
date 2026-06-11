<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Menjadwalkan reset jadwal kelas setiap hari Senin jam 00:00
Schedule::command('jadwal:reset-mingguan')->weeklyOn(1, '0:00');

// Menjadwalkan generate tagihan bulanan otomatis setiap hari
Schedule::command('billing:generate-monthly')->daily();
