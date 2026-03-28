<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HouseUser extends Model
{
    protected $table = 'house_user';

    protected $fillable = [
        'user_id',
        'house_id',
        'unlocked_at',
    ];

    protected static function booted()
    {
        static::creating(function ($houseUser) {
            if (empty($houseUser->unlocked_at)) {
                $houseUser->unlocked_at = $houseUser->created_at ?? now();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }
}
