<?php
namespace Modules\Helpers;
use Illuminate\Support\Arr;

class Hash {
    public static function control (string $hash, array $request, array $controlColumns): bool
    {
        $columnCount = str_repeat('%s', count($controlColumns) + 1);
        $cHash = sha1(sprintf($columnCount, ...array_values(array_merge(Arr::only($request, $controlColumns), ['salt' => env('SALT_KEY')])) ));
        return $cHash === $hash;
    }

    public static function controlReverse(string $hash, array $request, array $controlColumns): bool
    {
        $columnCount = str_repeat('%s', count($controlColumns) + 1);
        $cHash = sha1(sprintf($columnCount, env('SALT_KEY'), $request['callback_fail_url'], $request['callback_success_url'], $request['price']));
        return $cHash === $hash;
    }

    public static function calculate(array $values, array $controlColumns): string
    {
        $columnCount = str_repeat('%s', count($controlColumns) + 1);
        return sha1(sprintf($columnCount, ...array_values(array_merge(Arr::only($values, $controlColumns), ['salt' => env('SALT_KEY')])) ));
    }
    public static function calculateReverse(array $values, array $controlColumns): string
    {
        $columnCount = str_repeat('%s', count($controlColumns) + 1);
        return sha1(sprintf($columnCount, ...array_values(array_merge(['salt' => env('SALT_KEY')], Arr::only($values, $controlColumns) )) ));
    }
}

