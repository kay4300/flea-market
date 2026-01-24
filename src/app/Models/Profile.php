<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    // create_profile_tableのテーブル名
    protected $table = 'profiles';

    protected $fillable = [
        'user_id',
        'name',
        'postcode',
        'address',
        'building',
        'profile_image',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
