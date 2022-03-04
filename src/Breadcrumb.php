<?php

namespace ATStudio\Breadcrumbs;

use ATStudio\Breadcrumbs\Exceptions\InvalidBreadcrumbOptions;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class Breadcrumb
{
    /**
     * Breadcrumb item's label.
     */
    public readonly string $title;

    /**
     * An absolute URL to the breadcrumb's item.
     */
    public readonly string $path;

    public function __construct(
        string|array $title,
        ?string $path,
        mixed $params = null,
    )
    {
        if (is_string($title)) {
            $this->title = $title;
            $this->path = $this->parseUrl($path, $params);
        } else {
            $this->parseOptions($title);
        }
    }

    /**
     * Convert breadcrumb options into a title and a URL.
     */
    protected function parseOptions(array $options): void
    {
        if (!isset($options['title']) || !isset($options['path'])) {
            throw new InvalidBreadcrumbOptions('Parameter "$title" must either be a string or an array containing title and path keys.');
        }

        $this->title = $options['title'];
        $this->path = $this->parseUrl($options['path'], $options['params'] ?? []);
    }

    /**
     * Parse a path or a route name into an absolute URL.
     */
    protected function parseUrl(?string $path, mixed $params = null): string
    {
        if (!$path) return URL::current();

        // Determine whether the given URL is a route name
        if (Route::has($path)) {
            return route($path, Arr::wrap($params));
        }

        return url($path);
    }
}
