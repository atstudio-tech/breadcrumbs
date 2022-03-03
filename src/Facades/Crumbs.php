<?php

namespace ATStudio\Breadcrumbs\Facades;

use ATStudio\Breadcrumbs\BreadcrumbCollection;
use Illuminate\Support\Collection;

/**
 * @method static BreadcrumbCollection add(string|array $title, ?string $path = null, array $params = [])
 * @method static Collection all()
 */
class Crumbs extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'crumbs';
    }
}
