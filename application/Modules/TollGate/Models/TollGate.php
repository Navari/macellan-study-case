<?php

namespace Modules\TollGate\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Location\Models\Location;

class TollGate extends Model
{
    use HasFactory;
    protected $table = 'toll_gates';
    protected $fillable = [
        'name',
        'location_id',
    ];

    protected static function newFactory()
    {
        return \Modules\TollGate\Factories\TollGateFactory::new();
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

}
