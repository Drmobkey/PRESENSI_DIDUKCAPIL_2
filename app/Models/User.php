<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'status', 'tpdk_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasUuids, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    // public function Tpdk()
    // {
    //     return $this->belongsToMany(Tpdk::class, 'tpdk_user');
    // }

    public function Attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function Logbook()
    {
        return $this->hasMany(Logbook::class);
    }

    public function primary_tpdk()
    {
        return $this->belongsTo(Tpdk::class, 'tpdk_id');
    }

    public function tpdk()
    {
        return $this->belongsTo(Tpdk::class, 'tpdk_id');
    }
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

}
