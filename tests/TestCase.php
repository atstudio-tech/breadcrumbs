<?php

namespace ATStudio\Breadcrumbs\Tests;

use ATStudio\Breadcrumbs\BreadcrumbsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            BreadcrumbsServiceProvider::class,
        ];
    }
}
