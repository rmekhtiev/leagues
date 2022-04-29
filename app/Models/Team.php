<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Team extends Model
{
    use HasFactory;

    /* Settings */
    protected $fillable = [
        'title',
        'description',
        'league_id',
    ];

    /* Relations */
    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }
    /* Attributes */

    /* Functions */
}
