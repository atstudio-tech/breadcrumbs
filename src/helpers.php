<?php

use ATStudio\Breadcrumbs\Breadcrumbs;

if (!function_exists('crumbs')) {
    /**
     * A shorthand for calling Crumbs façade.
     */
    function crumbs(string|array|callable|null $title = null, ?string $path = null): Breadcrumbs
    {
        return tap(app('crumbs'), function (Breadcrumbs $crumbs) use ($path, $title) {
            if (is_callable($title)) {
                $title($crumbs);
            } elseif (!is_null($title)) {
                $crumbs->add($title, $path);
            }
        });
    }
}
