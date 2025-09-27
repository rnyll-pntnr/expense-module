<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Expenses\Providers\ExpenseServiceProvider;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getPackageProviders($app)
    {
        return [
            ExpenseServiceProvider::class,
        ];
    }
}
