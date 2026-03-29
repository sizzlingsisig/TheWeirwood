<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameStep extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'game_id',
        'choice_id',
        'sequence_order',
        'honor_before',
        'power_before',
        'debt_before',
        'honor_after',
        'power_after',
        'debt_after',
        'debt_multiplier_applied',
        'chosen_at',
    ];

    protected $casts = [
        'sequence_order' => 'integer',
        'honor_before' => 'integer',
        'power_before' => 'integer',
        'debt_before' => 'integer',
        'honor_after' => 'integer',
        'power_after' => 'integer',
        'debt_after' => 'integer',
        'debt_multiplier_applied' => 'float',
        'chosen_at' => 'datetime',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function choice(): BelongsTo
    {
        return $this->belongsTo(Choice::class);
    }
}
