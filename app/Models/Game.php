<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Game extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'player_id',
        'house_id',
        'region_id',
        'entry_mode',
        'honor',
        'power',
        'debt',
        'current_node_id',
        'is_complete',
        'session_started',
        'session_ended',
    ];

    protected $casts = [
        'honor' => 'integer',
        'power' => 'integer',
        'debt' => 'integer',
        'is_complete' => 'boolean',
        'session_started' => 'datetime',
        'session_ended' => 'datetime',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function currentNode(): BelongsTo
    {
        return $this->belongsTo(Node::class, 'current_node_id');
    }

    public function gameSteps(): HasMany
    {
        return $this->hasMany(GameStep::class)->orderBy('sequence_order');
    }

    public function debtEvents(): HasMany
    {
        return $this->hasMany(DebtEvent::class);
    }

    public function run(): HasOne
    {
        return $this->hasOne(Run::class);
    }

    public function getDebtMultiplier(): float
    {
        if ($this->debt >= 81) {
            return 1.6;
        }
        if ($this->debt >= 61) {
            return 1.3;
        }

        return 1.0;
    }

    public function isGameOver(): bool
    {
        return $this->honor <= 0 || $this->debt >= 100;
    }
}
