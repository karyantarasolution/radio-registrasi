<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'tahap',
        'status',
        'catatan',
        'is_urgent',
        'user_id',
    ];

    protected $casts = [
        'is_urgent' => 'boolean',
    ];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}