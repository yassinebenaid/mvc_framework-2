<?php

namespace Spoot\Testing;

use Closure;
use PHPUnit\Framework\TestCase as FrameworkTestCase;

class TestCase extends FrameworkTestCase
{
    protected function assertExceptionThrown(Closure $risky, string $exception_type)
    {
        $result = null;
        $exception = null;

        try {
            $result = $risky();
            $this->fail("exception not thrown !");
        } catch (\Throwable $th) {
            $actualtype = $th::class;

            if ($actualtype !== $exception_type) {
                $this->fail("exception was $actualtype , but expected $exception_type");
                $exception = $th;
            }
            return [$exception, $result];
        }
    }
}
