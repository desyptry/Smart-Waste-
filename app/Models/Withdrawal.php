<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'asessor_id',
        'amount',
        'method',
        'account_name',
        'account_number',
        'status',
        'approved_at',
    ];

    protected $casts = [
        'amount' => 'integer',
        'approved_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function asessor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asessor_id');
    }
}
