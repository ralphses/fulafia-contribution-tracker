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
        'payment_date',
        'created_by',
        'corperative_id',
        'status'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
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
