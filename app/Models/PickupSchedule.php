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
    ];

    
    public function collectionPoint(): BelongsTo
    {
        
        return $this->belongsTo(CollectionPoint::class, 'collection_point_id');
    }

    public function officer(): BelongsTo
    {
        return $this->belongsTo(OfficerDetail::class, 'officer_id');
    }

   
    public function wastePriceSchedules(): HasMany
    {
        
        return $this->hasMany(WastePriceSchedule::class, 'pickup_schedule_id');
    }
}