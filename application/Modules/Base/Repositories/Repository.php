<?php

namespace Modules\Base\Repositories;

use Illuminate\Support\Facades\App;


abstract class Repository
{
    protected static string $model;

    public function __call(string $name, array $arguments)
    {
        return App::make(static::$model)->{$name}(...$arguments);
    }

}
