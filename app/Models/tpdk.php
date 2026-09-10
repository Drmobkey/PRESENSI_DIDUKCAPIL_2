<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tpdk extends Model
{
    use SoftDeletes, HasFactory, HasUuids;
    protected $table = 'tpdk';

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'radius',
        'alamat'
    ];

    public function users()
    {
        // Relasi untuk mencari user yang mendaftar di TPDK ini
        return $this->hasMany(User::class, 'tpdk_id');
    }

    public function Attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function User_id()
    {
        return $this->hasMany(User::class);
    }


}
