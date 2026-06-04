<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WasteDeposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'drop_off_point_id',
        'pickup_schedule_id',
        'officer_id',
        'deposit_date',
    ];

    protected $casts = [
        'deposit_date' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dropOffPoint(): BelongsTo
    {
        return $this->belongsTo(DropOffPoint::class, 'drop_off_point_id');
    }

    public function pickupSchedule(): BelongsTo
    {
        return $this->belongsTo(PickupSchedule::class, 'pickup_schedule_id');
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }
}
