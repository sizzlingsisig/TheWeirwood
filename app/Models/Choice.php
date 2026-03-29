<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Choice extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_node_id',
        'to_node_id',
        'display_order',
        'required_house_id',
        'choice_text',
        'hint_text',
        'honor_delta',
        'power_delta',
        'debt_delta',
        'locks_on_high_debt',
    ];

    protected $casts = [
        'display_order' => 'integer',
        'honor_delta' => 'integer',
        'power_delta' => 'integer',
        'debt_delta' => 'integer',
        'locks_on_high_debt' => 'boolean',
        'requirements_json' => 'array',
    ];

    public function getRequirements(): ?array
    {
        return $this->requirements_json;
    }

    public function meetsRequirements(Game $game): bool
    {
        $requirements = $this->getRequirements();

        if (empty($requirements)) {
            return true;
        }

        if (isset($requirements['min_honor']) && $game->honor < $requirements['min_honor']) {
            return false;
        }

        if (isset($requirements['min_power']) && $game->power < $requirements['min_power']) {
            return false;
        }

        if (isset($requirements['required_flag']) && ! $game->hasFlag($requirements['required_flag'])) {
            return false;
        }

        if (isset($requirements['forbidden_flag']) && $game->hasFlag($requirements['forbidden_flag'], true)) {
            return false;
        }

        return true;
    }

    public function fromNode(): BelongsTo
    {
        return $this->belongsTo(Node::class, 'from_node_id');
    }

    public function toNode(): BelongsTo
    {
        return $this->belongsTo(Node::class, 'to_node_id');
    }

    public function requiredHouse(): BelongsTo
    {
        return $this->belongsTo(House::class, 'required_house_id');
    }
}
