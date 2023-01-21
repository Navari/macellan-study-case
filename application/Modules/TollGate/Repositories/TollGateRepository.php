<?php

namespace Modules\TollGate\Repositories;

use Modules\Base\Repositories\Repository;
use Modules\Location\Models\Location;
use Modules\TollGate\Models\TollGate;

class TollGateRepository extends Repository implements TollGateRepositoryInterface
{

    protected static string $model = TollGate::class;

    public function getLocation(int $id): ?Location
    {
        return $this->findOrFail($id)->location()->first();
    }
}
