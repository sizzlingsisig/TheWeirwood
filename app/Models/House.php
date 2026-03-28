<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'motto',
        'description',
        'sigil_image_path',
        'starting_honor',
        'starting_power',
        'starting_debt',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function regions()
    {
        return $this->hasMany(Region::class);
    }
}
