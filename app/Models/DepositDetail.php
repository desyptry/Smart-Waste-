<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DepositDetail extends Model
{
    use HasFactory;

    protected $table = 'deposit_details';

    protected $fillable = [
        'waste_deposit_id',
        'waste_price_id',
        'weight_kg',
        'total_price',
    ];

    protected $casts = [
        'weight_kg' => 'float',
        'total_price' => 'integer',
    ];

    public function wasteDeposit(): BelongsTo
    {
        return $this->belongsTo(WasteDeposit::class, 'waste_deposit_id');
    }

    public function wastePrice(): BelongsTo
    {
        return $this->belongsTo(SchedulePrice::class, 'waste_price_id');
    }
}
