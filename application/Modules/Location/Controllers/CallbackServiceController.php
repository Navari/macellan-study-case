<?php

namespace Modules\Location\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Helpers\Hash;
use Modules\Location\{
    Exceptions\HashInvalid,
    Jobs\OpenGate,
    Repositories\LocationRepositoryInterface,
    Requests\CallbackServiceRequest
};
use Modules\TollGate\Repositories\TollGateRepositoryInterface;

class CallbackServiceController extends Controller
{
    public function __construct(
        private TollGateRepositoryInterface $tollGateRepository,
        private LocationRepositoryInterface $locationRepository
    ){}

    public function __invoke(CallbackServiceRequest $request): JsonResponse
    {
        if(!Hash::controlReverse($request->hash, $request->all(), ['callback_fail_url', 'callback_success_url', 'price'])){
            throw new HashInvalid();
        }

        dispatch(new OpenGate($request->all(), $this->tollGateRepository, $this->locationRepository));

        return response()->json([], 200);
    }
}
