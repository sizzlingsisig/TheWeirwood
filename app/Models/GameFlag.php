<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameFlag extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'flag_key',
        'value',
    ];

    protected $casts = [
        'value' => 'boolean',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
