<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DropOffPoint extends Model
{
    use HasFactory;

    protected $table = 'drop_off_points';

    
    protected $fillable = [
        'foreignKey',
        'name',
        'location',
        'latitude',
  'assesor_id',
        'longitude',
    ];

    /**
     * Relasi ke tabel Schedules
     * Satu Drop Off Point bisa memiliki banyak Schedule (Jadwal)
     */
    public function schedules(): HasMany
    {
        // Parameter kedua adalah nama foreign key di tabel schedules yang merujuk ke tabel ini
        return $this->hasMany(Schedule::class, 'collection_point_id');
    }
  public function assesor(): BelongsTo
    {
        // Parameter kedua ('assesor_id') ditulis opsional jika nama kolomnya sudah sesuai konvensi
        return $this->belongsTo(User::class, 'assesor_id');
    }
}