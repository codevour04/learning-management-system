<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['transaction_number', 'date', 'status', 'customer_id'];


    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function salesAgent(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function preApprover(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function finalApprover(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
