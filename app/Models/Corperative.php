<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Corperative extends Model
{
    /** @use HasFactory<\Database\Factories\CorperativeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'user_id'
    ];

    public function createdBy() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function members() : BelongsToMany
    {
        return $this->belongsToMany(User::class, "corperative_user", "corperative_id", "user_id");
    }

    public function contributionSchemes()
    {
        return $this->hasMany(ContributionScheme::class);
    }
}

