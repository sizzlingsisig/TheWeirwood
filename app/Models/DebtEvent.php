<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DebtEvent extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'debt_events';

    protected $fillable = [
        'game_id',
        'event_type',
        'debt_value_at_event',
        'multiplier_used',
        'triggered_at_node',
        'occurred_at',
    ];

    protected $casts = [
        'debt_value_at_event' => 'integer',
        'multiplier_used' => 'float',
        'triggered_at_node' => 'integer',
        'occurred_at' => 'datetime',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function node(): BelongsTo
    {
        return $this->belongsTo(Node::class, 'triggered_at_node');
    }
}
