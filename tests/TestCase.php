<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function disableExceptionHandling()
    {
        $this->app->instance(\Illuminate\Contracts\Debug\ExceptionHandler::class, new class extends Handler
        {
            public function render($request, \Exception $e)
            {
                throw $e;
            }
        });
    }
}
