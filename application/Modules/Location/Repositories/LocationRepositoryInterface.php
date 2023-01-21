<?php

namespace Modules\Location\Repositories;

interface LocationRepositoryInterface
{

    public function addTransaction(int $id, int $tollGateId, int $userId, int $price, string $orderId): void;

    public function getEntranceCountByUserIdAndDate(int $id, int $userId, string $date): int;

    public function getEntranceCountByDate(int $id, string $date): int;

}
