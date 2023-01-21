<?php

namespace Modules\Location\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\TollGate\Models\Transaction;

class Location extends Model
{
    use HasFactory;
    protected $table = 'locations';
    protected $fillable = [
        'name',
        'entrance_limit',
        'price'
    ];

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    protected static function newFactory()
    {
        return \Modules\Location\Factories\LocationFactory::new();
    }
}
