<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    public function register(): void
    {
        $this->renderable(function (ValidationFailedException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['code' => 400, 'msg' => $e->getMessage()], 400);
            }
        });
    }
}
