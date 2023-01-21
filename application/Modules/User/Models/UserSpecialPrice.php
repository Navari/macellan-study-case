<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSpecialPrice extends Model
{
    use HasFactory;
    protected $table = 'user_special_prices';
    protected $fillable = [
        'user_id',
        'product_id',
        'price',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
