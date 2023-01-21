<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Helpers\Hash;
use Modules\TollGate\Models\TollGate;
use Modules\User\Models\User;
use Tests\TestCase;

class PriceServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_the_price_service_returns_a_successful_response()
    {
        $user = User::factory()->create();
        $refCode = TollGate::factory()->create()->id;
        $orderId = (string)rand(9999, 100000);
        $hash = Hash::calculate(['user_id' => $user->id, 'ref_code' => $refCode, 'order_id' => $orderId, 'hash' => 'hash'], ['ref_code', 'user_id', 'order_id']);
        $response = $this->post('/api/get-price', [
            'user_id' => (string)$user->id,
            'ref_code' => (string)$refCode,
            'order_id' => $orderId,
            'hash' => $hash
        ], ['Accept' => 'application/json']);

        $response->assertStatus(200);
    }

    public function test_the_price_service_returns_a_price_response(){
        $user = User::factory()->create();
        $refCode = TollGate::factory()->create()->id;
        $orderId = (string)rand(9999, 100000);
        $hash = Hash::calculate(['user_id' => $user->id, 'ref_code' => $refCode, 'order_id' => $orderId, 'hash' => 'hash'], ['ref_code', 'user_id', 'order_id']);
        $response = $this->post('/api/get-price', [
            'user_id' => (string)$user->id,
            'ref_code' => (string)$refCode,
            'order_id' => $orderId,
            'hash' => $hash
        ], ['Accept' => 'application/json']);

        $response->assertJsonStructure([
            'price'
        ]);
    }

    public function test_the_price_service_returns_a_bad_hash_response()
    {
        $user = User::factory()->create();
        $refCode = TollGate::factory()->create()->id;
        $response = $this->post('/api/get-price', [
            'user_id' => (string)$user->id,
            'ref_code' => (string)$refCode,
            'order_id' => (string)rand(9999, 100000),
            'hash' => 'hash'
        ], ['Accept' => 'application/json']);

        $response->assertStatus(403);
    }

    public function test_the_price_service_returns_a_validation_error()
    {
        $user = User::factory()->create();
        $refCode = TollGate::factory()->create()->id;
        $orderId = rand(9999, 100000);
        $hash = Hash::calculate(['user_id' => $user->id, 'ref_code' => $refCode, 'order_id' => $orderId, 'hash' => 'hash'], ['ref_code', 'user_id', 'order_id']);
        $response = $this->post('/api/get-price', [
            'user_id' => (string)$user->id,
            'ref_code' => rand(19,100),
            'order_id' => rand(9999, 100000),
            'hash' => $hash
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422);

    }
}
