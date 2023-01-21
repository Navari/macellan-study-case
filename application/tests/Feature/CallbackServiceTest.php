<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Helpers\Hash;
use Modules\TollGate\Models\TollGate;
use Modules\User\Models\User;
use Tests\TestCase;

class CallbackServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_callback_service_returns_a_successfully_response()
    {
        $user = User::factory()->create();
        $refCode = TollGate::factory()->create()->id;
        $orderId = (string)rand(9999, 100000);
        $hash = Hash::calculateReverse(['callback_fail_url' => 'https://case.altpay.dev/fail', 'callback_success_url' =>'https://case.altpay.dev/success', 'price' => '55.33'], ['callback_fail_url', 'callback_success_url', 'price']);
        $response = $this->post('/api/callback', [
            'price' => '55.33',
            'point' => '0.00',
            'user_id' => (string)$user->id,
            'ref_code' => (string)$refCode,
            'order_id' => $orderId,
            'callback_success_url' => 'https://case.altpay.dev/success',
            'callback_fail_url' => 'https://case.altpay.dev/fail',
            'hash' => $hash
        ], ['Accept' => 'application/json']);

        $response->assertStatus(200);
    }

    public function test_the_callback_service_returns_a_bad_hash_response(){
        $user = User::factory()->create();
        $refCode = TollGate::factory()->create()->id;
        $orderId = (string)rand(9999, 100000);
        $hash = Hash::calculateReverse(['callback_fail_url' => 'https://case.altpay.dev/fail', 'callback_success_url' =>'https://case.altpay.dev/success', 'price' => '55.33'], ['callback_fail_url', 'callback_success_url', 'price']);
        $response = $this->post('/api/callback', [
            'price' => '55.33',
            'point' => '0.00',
            'user_id' => (string)$user->id,
            'ref_code' => (string)$refCode,
            'order_id' => $orderId,
            'callback_success_url' => 'https://case.altpay.dev/success',
            'callback_fail_url' => 'https://case.altpay.dev/fail',
            'hash' => 'hash'
        ], ['Accept' => 'application/json']);

        $response->assertStatus(403);
    }

    public function test_the_callback_service_returns_a_validation_error (){
        $user = User::factory()->create();
        $refCode = TollGate::factory()->create()->id;
        $orderId = (string)rand(9999, 100000);
        $hash = Hash::calculateReverse(['callback_fail_url' => 'https://case.altpay.dev/fail', 'callback_success_url' =>'https://case.altpay.dev/success', 'price' => '55.33'], ['callback_fail_url', 'callback_success_url', 'price']);
        $response = $this->post('/api/callback', [
            'price' => '55.33',
            'point' => '0.00',
            'user_id' => (string)$user->id,
            'ref_code' => (string)$refCode,
            'order_id' => $orderId,
            'callback_success_url' => 'https://case.altpay.dev/success',
            'callback_fail_url' => null,
            'hash' => $hash
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422);
    }

    public function test_the_callback_service_returns_user_not_exists_error (){
        $user = User::factory()->create();
        $refCode = TollGate::factory()->create()->id;
        $orderId = (string)rand(9999, 100000);
        $hash = Hash::calculateReverse(['callback_fail_url' => 'https://case.altpay.dev/fail', 'callback_success_url' =>'https://case.altpay.dev/success', 'price' => '55.33'], ['callback_fail_url', 'callback_success_url', 'price']);
        $response = $this->post('/api/callback', [
            'price' => '55.33',
            'point' => '0.00',
            'user_id' => rand(999999, 191991919),
            'ref_code' => (string)$refCode,
            'order_id' => $orderId,
            'callback_success_url' => 'https://case.altpay.dev/success',
            'callback_fail_url' => 'https://case.altpay.dev/fail',
            'hash' => $hash
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422);
    }
}
