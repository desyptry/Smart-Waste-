<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WastePriceSchedule extends Model
{
    use HasFactory;

    protected $table = 'schedule_prices';

    protected $fillable = [
        'pickup_schedule_id',
        'waste_category_id',
        'type_name',
        'price',
        'rules',
        'description',
        'photo',
    ];

    
    public function pickupSchedule()
    {
        return $this->belongsTo(PickupSchedule::class, 'pickup_schedule_id');
    }

    public function wasteCategory()
    {
        return $this->belongsTo(WasteCategory::class, 'waste_category_id');
    }
}
