<?php

use ATStudio\Breadcrumbs\BreadcrumbCollection;

if (!function_exists('crumbs')) {
    /**
     * A shorthand for calling Crumbs façade.
     */
    function crumbs(string|array|callable|null $title = null, ?string $path = null, mixed $params = null): BreadcrumbCollection
    {
        return tap(app('crumbs'), function (BreadcrumbCollection $crumbs) use ($params, $path, $title) {
            if (is_callable($title)) {
                $title($crumbs);
            } elseif (!is_null($title)) {
                $crumbs->add($title, $path, $params);
            }
        });
    }
}
