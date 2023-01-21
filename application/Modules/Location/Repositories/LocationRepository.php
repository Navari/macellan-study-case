<?php

namespace Modules\Location\Repositories;

use Modules\Base\Repositories\Repository;
use Modules\Location\Models\Location;

class LocationRepository extends Repository implements LocationRepositoryInterface
{

    protected static string $model = Location::class;



    public function addTransaction(int $id, int $tollGateId, int $userId, int $price, string $orderId): void
    {
        $this->find($id)->transactions()->create([
            'toll_gate_id' => $tollGateId,
            'user_id' => $userId,
            'price' => $price,
            'order_id' => $orderId
        ]);
    }

    public function getEntranceCountByUserIdAndDate(int $id, int $userId, string $date): int
    {
        return $this->find($id)->transactions()->where('user_id', $userId)->whereDate('created_at', $date)->count();
    }

    public function getEntranceCountByDate(int $id, string $date): int
    {
        return $this->find($id)->transactions()->whereDate('created_at', $date)->count();
    }
}
