<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory, HasUuids;
    //
    protected $table = 'logbooks';

    protected $fillable = [
        'user_id',
        'date',
        'description',
        'status',
        'rejection_note'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
