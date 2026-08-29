<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tpdk extends Model
{
    use SoftDeletes, HasFactory, HasUuids;
    protected $table = 'tpdk';

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'radius',
    ];

    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'tpdk_user');
    // }

    public function Attendance()
    {
        return $this->hasMany(attendance::class);
    }

    public function User_id()
    {
        return $this->hasMany(User::class);
    }


}
