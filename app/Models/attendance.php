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
            'is_late',
            'late_duration',

        ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tpdk()
    {
        return $this->belongsTo(Tpdk::class, 'tpdk_id');
    }

    public function getLogbookAttribute()
    {
        return Logbook::where('user_id', $this->user_id)
            ->whereDate('date', $this->date)
            ->first();
    }

    public function getFormattedLateDurationAttribute()
    {
        if (!$this->late_duration) return null;
        
        $hours = floor($this->late_duration / 60);
        $minutes = $this->late_duration % 60;
        
        if ($hours > 0 && $minutes > 0) {
            return "{$hours} Jam {$minutes} Menit";
        } elseif ($hours > 0) {
            return "{$hours} Jam";
        } else {
            return "{$minutes} Menit";
        }
    }
}
