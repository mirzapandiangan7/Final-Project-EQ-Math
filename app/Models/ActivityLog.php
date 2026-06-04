<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;

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
 */
class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'causer_id',
        'subject_type',
        'subject_id',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Static log method for manual logging
     */
    public static function log(string $description, ?Model $subject = null, ?array $properties = null): self
    {
        return self::create([
            'description' => $description,
            'causer_id' => Auth::id(),
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'properties' => $properties,
        ]);
    }

    /**
     * Relasi ke aktor yang melakukan aksi
     */
    public function causer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'causer_id');
    }

    /**
     * Relasi polymorphic ke target/subject aksi
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Helper untuk mendapatkan properties sebagai array
     */
    public function changes(): array
    {
        return $this->properties ?? [];
    }
}
