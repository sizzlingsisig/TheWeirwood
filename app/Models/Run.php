<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Run extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'game_id',
        'player_id',
        'house_id',
        'region_id',
        'starting_node_id',
        'ending_node_id',
        'final_honor',
        'final_power',
        'final_debt',
        'steps_taken',
        'is_victory',
        'unlocked_house_id',
        'completed_at',
    ];

    protected $casts = [
        'final_honor' => 'integer',
        'final_power' => 'integer',
        'final_debt' => 'integer',
        'steps_taken' => 'integer',
        'is_victory' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class, 'house_id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function startingNode(): BelongsTo
    {
        return $this->belongsTo(Node::class, 'starting_node_id');
    }

    public function endingNode(): BelongsTo
    {
        return $this->belongsTo(Node::class, 'ending_node_id');
    }

    public function unlockedHouse(): BelongsTo
    {
        return $this->belongsTo(House::class, 'unlocked_house_id');
    }
}
