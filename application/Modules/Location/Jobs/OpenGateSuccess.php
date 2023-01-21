<?php

namespace Modules\Location\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Helpers\Hash;

class OpenGateSuccess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private array $requestValues,
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
        $hash = Hash::calculate($this->requestValues, ['price', 'callback_success_url', 'callback_fail_url']);
        $client = new \GuzzleHttp\Client();
        $client->request('POST', $this->requestValues['callback_success_url'], [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'hash' => $hash,
            ])
        ]);

    }
}
