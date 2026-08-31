<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'work_schedules';
    protected $fillable = ['day_of_week', 'start_time', 'end_time'];
}
