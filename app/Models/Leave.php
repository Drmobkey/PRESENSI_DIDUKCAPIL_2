<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use HasUuids, HasFactory, SoftDeletes;
    protected $table = 'leaves';

    protected $fillable = [
        'user_id',
        'type',
        'start_date',
        'end_date',
        'reason',
        'attachment',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
