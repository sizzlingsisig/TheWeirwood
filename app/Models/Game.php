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

    public function flags(): HasMany
    {
        return $this->hasMany(GameFlag::class);
    }

    public function getFlag(string $key): ?bool
    {
        $flag = $this->flags()->where('flag_key', $key)->first();

        return $flag?->value;
    }

    public function hasFlag(string $key, bool $value = true): bool
    {
        return $this->getFlag($key) === $value;
    }

    public function setFlag(string $key, bool $value = true): self
    {
        $this->flags()->updateOrCreate(
            ['flag_key' => $key],
            ['value' => $value]
        );

        return $this;
    }

    public function isGameOver(): bool
    {
        return $this->honor <= 0 || $this->debt >= 100;
    }
}
