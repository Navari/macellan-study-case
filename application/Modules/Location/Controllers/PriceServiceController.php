<?php

namespace Modules\Location\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Location\{
    Exceptions\HashInvalid,
    Requests\PriceServiceRequest
};
use Modules\TollGate\Repositories\TollGateRepositoryInterface;
use Modules\User\Repositories\UserRepositoryInterface;
use Modules\Helpers\Hash;

class PriceServiceController extends Controller
{

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private TollGateRepositoryInterface $tollGateRepository
    ){}

    /**
     * @throws HashInvalid
     */
    public function __invoke(PriceServiceRequest $request): JsonResponse
    {
        if(!Hash::control($request->hash, $request->all(), ['user_id', 'ref_code', 'order_id'])){
            throw new HashInvalid();
        }

        $location = $this->tollGateRepository->getLocation($request->ref_code);

        $userSpecialPrice = $this->userRepository->getSpecialPriceByLocationId($request->user_id, $location->id);

        if($userSpecialPrice){
            return response()->json([
                'price' => $userSpecialPrice,
            ]);
        }

        return response()->json([
            'price' => $location->price,
        ]);
    }
}
