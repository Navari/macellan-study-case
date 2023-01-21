<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\TollGate\Models\Transaction;

class UserAccess extends Model
{
    use HasFactory;
    protected $table = 'user_accesses';
    protected $fillable = [
        'user_id',
        'transaction_id',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
