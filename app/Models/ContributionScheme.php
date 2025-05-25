<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContributionScheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'penalty_fee',
        'payment_time',
        'created_by',
        'individual_amount',
        'total_times',
        'corperative_id',
        'status'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function members()
    {
        return $this->belongsToMany(
            User::class,
            'contribution_scheme_user',     // Pivot table name
            'contribution_scheme_id',       // Foreign key on pivot table for this model
            'user_id'                       // Foreign key on pivot table for the related model
        )->withTimestamps();               // If timestamps are enabled in the pivot table
    }


    public function userContributions(): HasMany
    {
        return $this->hasMany(UserContribution::class);
    }

    public function corperative(): BelongsTo
    {
        return $this->belongsTo(Corperative::class);
    }
}
