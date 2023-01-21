<?php

namespace Modules\TollGate\Repositories;

use Modules\Location\Models\Location;

interface TollGateRepositoryInterface
{
    public function getLocation(int $id): ?Location;
}
