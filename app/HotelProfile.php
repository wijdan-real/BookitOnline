<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelProfile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $fillable = [
        'user_id',
    ];
}
