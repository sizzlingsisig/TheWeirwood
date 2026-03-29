<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    use HasFactory;

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

    public function choices()
    {
        return $this->hasMany(Choice::class, 'from_node_id');
    }

    public function nextNodes()
    {
        return $this->hasMany(Choice::class, 'to_node_id');
    }

    public function ending()
    {
        return $this->hasOne(Ending::class);
    }
}
