<?php

namespace Tests\Unit;

use Illuminate\Http\Request;
use Modules\Helpers\Hash;
use PHPUnit\Framework\TestCase;

class HashTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_hash_normal_functions()
    {
        $hash = Hash::calculate(['callback_fail_url' => 'https://case.altpay.dev/fail', 'callback_success_url' =>'https://case.altpay.dev/success', 'price' => '55.33'], ['callback_fail_url', 'callback_success_url', 'price']);
        $controlHash = Hash::control($hash, ['callback_fail_url' => 'https://case.altpay.dev/fail', 'callback_success_url' =>'https://case.altpay.dev/success', 'price' => '55.33'], ['callback_fail_url', 'callback_success_url', 'price']);
        $this->assertTrue($hash == $controlHash);
    }
    public function test_hash_reverse_functions()
    {
        $hash = Hash::calculateReverse(['callback_fail_url' => 'https://case.altpay.dev/fail', 'callback_success_url' =>'https://case.altpay.dev/success', 'price' => '55.33'], ['callback_fail_url', 'callback_success_url', 'price']);
        $controlHash = Hash::controlReverse($hash, ['callback_fail_url' => 'https://case.altpay.dev/fail', 'callback_success_url' =>'https://case.altpay.dev/success', 'price' => '55.33'], ['callback_fail_url', 'callback_success_url', 'price']);
        $this->assertTrue($hash == $controlHash);
    }
}
