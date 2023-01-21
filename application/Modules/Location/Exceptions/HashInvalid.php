<?php

namespace Modules\Location\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class HashInvalid extends HttpException
{

    public function __construct(string $message = "Hash invalid", int $code = 403, Throwable $previous = null)
    {
        parent::__construct(403, $message, $previous);
    }
}
