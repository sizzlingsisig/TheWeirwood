<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
        'name',
        'description',
        'house_id',
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
