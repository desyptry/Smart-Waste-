<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WasteCategory extends Model
{
    use HasFactory;

    protected $table = 'waste_categories';

    protected $fillable = [
        'name',
        'description',
        'photo',
        'rules',
    ];


    public function schedulePrices()
    {
        return $this->hasMany(SchedulePrice::class, 'category_id');
    }

    public function depositDetails()
    {
        return $this->hasMany(DepositDetail::class, 'waste_id');
    }
}
