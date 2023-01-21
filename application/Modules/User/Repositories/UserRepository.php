<?php

namespace Modules\User\Repositories;

use Modules\Base\Repositories\Repository;
use Modules\User\Models\User;

class UserRepository extends Repository implements UserRepositoryInterface
{

    protected static string $model = User::class;

    public function getSpecialPriceByLocationId(int $userId, int $locationId): float | null
    {
        return $this->find($userId)->specialPrices()->where('location_id', $locationId)->first()->price ?? null;
    }
}
