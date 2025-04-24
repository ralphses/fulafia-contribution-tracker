<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Contribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'contributed_at',
        'user_contribution_id',
        'note',
        'receipt_path',
        'status',
        'admin_note',
    ];

    protected $dates = [
        'contributed_at',
    ];

    public function userContribution()
    {
        return $this->belongsTo(UserContribution::class, 'user_contribution_id');
    }

    /**
     * Accessor: Get the full URL of the uploaded receipt.
     */
    public function getReceiptUrlAttribute()
    {
        return $this->receipt_path ? asset('storage/' . $this->receipt_path) : null;
    }

    /**
     * Upload a receipt for this contribution.
     *
     * @param UploadedFile $file
     * @return void
     */
    public function uploadReceipt(UploadedFile $file)
    {
        // Delete existing receipt if it exists
        if ($this->receipt_path && Storage::disk('public')->exists($this->receipt_path)) {
            Storage::disk('public')->delete($this->receipt_path);
        }

        // Store new file
        $path = $file->store('receipts', 'public');

        // Update the contribution with the new path
        $this->update(['receipt_path' => $path]);
    }

    /**
     * Scope: Filter approved contributions.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: Filter pending contributions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Filter rejected contributions.
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Human-readable status label.
     */
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    /**
     * Human-readable type label.
     */
    public function getTypeLabelAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->type));
    }
}
