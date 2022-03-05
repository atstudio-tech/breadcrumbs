<?php

namespace ATStudio\Breadcrumbs\Facades;

/**
 * @method static \ATStudio\Breadcrumbs\BreadcrumbCollection add(string|array $title, ?string $path = null, mixed $params = null)
 * @method static \Illuminate\Support\Collection all()
 * @method static \Illuminate\View\View render(?string $view = null)
 * @method static string toJson()
 * @method static array toArray()
 * @method static int count()
 */
class Crumbs extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'crumbs';
    }
}
