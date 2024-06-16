<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class User extends Authenticatable
{
    use HasFactory, Notifiable, LogsActivity;

    const TYPE_ADMIN = 'admin';

    const TYPE_PLAYER = 'player';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'type',
        'password',
        'is_blocked',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function player(): HasOne
    {
        return $this->hasOne(Player::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(
            Transaction::class,
            'from',
        )->orWhere('to', $this->id);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'phone_number', 'type', 'is_blocked']);
    }
}
