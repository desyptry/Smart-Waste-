<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PickupSchedule extends Model
{
    use HasFactory;

    protected $table = 'pickup_schedules';

    protected $fillable = [
        'officer_id',
        'collection_point_id',
        'start_date',
        'finish_date',
  'status',
  'declined_reason'
    ];

    // Diubah menjadi dropOffPoint (tunggal) karena belongsTo hanya mengembalikan 1 objek lokasi
    public function dropOffPoint(): BelongsTo
    {
        return $this->belongsTo(DropOffPoint::class, 'collection_point_id');
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(OfficerDetail::class, 'officer_id');
    }

    public function schedulePrices(): HasMany
    {
        return $this->hasMany(SchedulePrice::class, 'pickup_schedule_id');
    }
}
