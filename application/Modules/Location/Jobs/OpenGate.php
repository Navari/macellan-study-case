<?php

namespace Modules\Location\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Location\Exceptions\TotalEntranceLimitExceeded;
use Modules\Location\Repositories\LocationRepositoryInterface;
use Modules\TollGate\Repositories\TollGateRepositoryInterface;

class OpenGate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private array $requestValues,
        private TollGateRepositoryInterface $tollGateRepository,
        private LocationRepositoryInterface $locationRepository
    )
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $location = $this->tollGateRepository->getLocation($this->requestValues['ref_code']);
        $locationEntranceCountToday = $this->locationRepository->getEntranceCountByDate($location->id, date('Y-m-d'));
        if($locationEntranceCountToday >= $location->entrance_limit){
            dispatch(new OpenGateFail($this->requestValues));
            $this->fail(new TotalEntranceLimitExceeded('Total entrance limit exceeded'));
            return;
        }
        $locationUserEntranceCountToday = $this->locationRepository->getEntranceCountByUserIdAndDate($location->id, $this->requestValues['user_id'], date('Y-m-d'));
        if($locationUserEntranceCountToday >= $location->user_entrance_limit){
            dispatch(new OpenGateFail($this->requestValues));
            $this->fail(new TotalEntranceLimitExceeded('Users entrance limit exceeded'));
            return;
        }

        $this->locationRepository->addTransaction($location->id, $this->requestValues['ref_code'], $this->requestValues['user_id'], $this->requestValues['price'], $this->requestValues['order_id']);

        dispatch(new OpenGateSuccess($this->requestValues));

    }
}
