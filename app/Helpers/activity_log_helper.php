<?php

if (!function_exists('catatLog')) {
    /**
     * Helper global untuk mencatat log aktivitas
     *
     * @param string $description Deskripsi aktivitas (misal: 'Mendaftar Kelas')
     * @param \Illuminate\Database\Eloquent\Model|null $subject Model yang terkait (misal: Model Transaksi)
     * @param array|null $properties Data tambahan (misal: ['metode' => 'Midtrans'])
     * @return \App\Models\ActivityLog
     */
    function catatLog(string $description, ?\Illuminate\Database\Eloquent\Model $subject = null, ?array $properties = null)
    {
        return \App\Models\ActivityLog::log($description, $subject, $properties);
    }
}
