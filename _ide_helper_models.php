<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\ActivityLog
 *
 * @property int $id
 * @property string $description
 * @property int|null $causer_id
 * @property string|null $subject_type
 * @property int|null $subject_id
 * @property array|null $properties
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $causer
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $subject
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog with($relations)
 * @mixin \Eloquent
 * @property string|null $log_name
 * @property string|null $event
 * @property string|null $causer_type
 * @property string|null $batch_uuid
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereBatchUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereCauserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereCauserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereLogName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActivityLog whereUpdatedAt($value)
 */
	class ActivityLog extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $kelas_id
 * @property int $pengajar_id
 * @property string $hari
 * @property string $jam_mulai
 * @property string $jam_selesai
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $status_jadwal
 * @property-read \App\Models\MasterKelas|null $masterKelas
 * @property-read \App\Models\MasterPengajar|null $masterPengajar
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransaksiPembayaran> $transaksiPembayaran
 * @property-read int|null $transaksi_pembayaran_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalKelas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalKelas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalKelas query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalKelas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalKelas whereHari($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalKelas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalKelas whereJamMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalKelas whereJamSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalKelas whereKelasId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalKelas wherePengajarId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalKelas whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JadwalKelas whereUpdatedAt($value)
 */
	class JadwalKelas extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_kelas
 * @property string $jenjang
 * @property numeric $harga
 * @property string|null $deskripsi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JadwalKelas> $jadwalKelas
 * @property-read int|null $jadwal_kelas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransaksiPembayaran> $transaksiPembayaran
 * @property-read int|null $transaksi_pembayaran_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKelas newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKelas newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKelas query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKelas whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKelas whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKelas whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKelas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKelas whereJenjang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKelas whereNamaKelas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterKelas whereUpdatedAt($value)
 */
	class MasterKelas extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_pengajar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JadwalKelas> $jadwalKelas
 * @property-read int|null $jadwal_kelas_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPengajar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPengajar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPengajar query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPengajar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPengajar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPengajar whereNamaPengajar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MasterPengajar whereUpdatedAt($value)
 */
	class MasterPengajar extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $order_id
 * @property int $user_id
 * @property int $jadwal_id
 * @property \Illuminate\Support\Carbon|null $tanggal_bayar
 * @property int $jumlah_bayar
 * @property string|null $snap_token
 * @property string $status_pembayaran
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\JadwalKelas|null $jadwalKelas
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiPembayaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiPembayaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiPembayaran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiPembayaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiPembayaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiPembayaran whereJadwalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiPembayaran whereJumlahBayar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiPembayaran whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiPembayaran whereSnapToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiPembayaran whereStatusPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiPembayaran whereTanggalBayar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiPembayaran whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TransaksiPembayaran whereUserId($value)
 */
	class TransaksiPembayaran extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_lengkap
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string $role
 * @property string $no_wa
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransaksiPembayaran> $transaksiPembayaran
 * @property-read int|null $transaksi_pembayaran_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNamaLengkap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNoWa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

