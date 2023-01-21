<?php

namespace Modules\User\Repositories;

interface UserRepositoryInterface
{
    public function getSpecialPriceByLocationId(int $userId, int $locationId): float | null;
}
