<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Node extends Model
{
    protected $fillable = [
        'node_code',
        'chapter_label',
        'title',
        'art_image_path',
        'narrative_text',
        'debt_warning_text',
        'debt_warning_threshold',
        'is_ending',
    ];

    protected $casts = [
        'is_ending' => 'boolean',
        'debt_warning_threshold' => 'integer',
    ];

    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class, 'from_node_id');
    }

    public function nextNodes(): HasMany
    {
        return $this->hasMany(Choice::class, 'to_node_id');
    }
}
