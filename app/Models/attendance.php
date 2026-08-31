<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    //

    use SoftDeletes, HasFactory, HasUuids;

    protected $table = 'attendances';

    protected $fillable =
        [
            'user_id',
            'tpdk_id',
            'date',
            'time_in',
            'time_out',
            'lat_in',
            'long_in',
            'photo_in',
            'photo_out',
            'status',

        ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Tpdks()
    {
        return $this->belongsTo(Tpdk::class);
    }
}
