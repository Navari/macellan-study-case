<?php

namespace Modules\TollGate\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Location\Models\Location;
use Modules\User\Models\UserAccess;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'order_id',
        'price',
        'user_id',
        'location_id',
        'toll_gate_id',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function userAccess()
    {
        return $this->hasOne(UserAccess::class);
    }

}
