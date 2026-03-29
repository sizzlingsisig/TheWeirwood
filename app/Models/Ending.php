<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ending extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'node_id',
        'verdict_label',
        'ending_type',
        'ending_text',
        'required_house_id',
        'unlocks_house_id',
    ];

    public function node(): BelongsTo
    {
        return $this->belongsTo(Node::class);
    }

    public function requiredHouse(): BelongsTo
    {
        return $this->belongsTo(House::class, 'required_house_id');
    }

    public function unlockedHouse(): BelongsTo
    {
        return $this->belongsTo(House::class, 'unlocks_house_id');
    }
}
