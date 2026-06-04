<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfficerDetail extends Model
{
    use HasFactory;

    protected $table = 'officer_details';

    protected $fillable = [
        'user_id',
        'collection_point_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function collectionPoint(): BelongsTo
    {
        return $this->belongsTo(CollectionPoint::class, 'collection_point_id');
    }
}
