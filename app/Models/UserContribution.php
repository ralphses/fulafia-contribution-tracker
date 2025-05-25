<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContribution extends Model
{
    /** @use HasFactory<\Database\Factories\UserContributionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'contribution_scheme_id',
        'total_amount',
        'withdrawal_status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function contributions() {
        return $this->hasMany(Contribution::class);
    }

    public function contributionScheme() {
        return $this->belongsTo(ContributionScheme::class);
    }
}
