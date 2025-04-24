<?php

namespace App\Models;

use App\Utils\Utils;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',          // ENUM: admin, staff, student
        'phone_number',
        'status',        // ENUM: active, inactive
    ];

    /**
     * The attributes that should be hidden for arrays and JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel 10+ for automatic hashing
    ];

    /**
     * Accessor to check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === Utils::ROLE_ADMIN;
    }

    /**
     * Accessor to check if user is a staff member.
     */
    public function isStaff(): bool
    {
        return $this->role === Utils::ROLE_STAFF;
    }

    /**
     * Accessor to check if user is a student.
     */
    public function isStudent(): bool
    {
        return $this->role === Utils::ROLE_STUDENT;
    }


    /**
     * Example relationship: Notifications sent to the user
     */
    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable');
    }

    public function corperatives()
    {
        return $this->belongsToMany(
            Corperative::class,
            'corperative_user',
            'user_id',
            'corperative_id'
        );
    }

    public function contributionScheme()
    {
        return $this->belongsToMany(ContributionScheme::class);
    }

    public function userContributions()
    {
        return $this->hasMany(UserContribution::class);
    }

    public function contributions(): HasMany
    {
        return $this->hasMany(Contribution::class);
    }
}
