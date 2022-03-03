<?php

namespace ATStudio\Breadcrumbs;

use Illuminate\Support\Collection;

class BreadcrumbCollection
{
    /**
     * A list of breadcrumbs' items.
     *
     * @var Collection<int, Breadcrumb>
     */
    protected Collection $crumbs;

    public function __construct()
    {
        $this->crumbs = collect();
    }

    /**
     * Get current instance of the class.
     */
    public static function instance(): static
    {
        return app('crumbs');
    }

    /**
     * Return all existing breadcrumbs.
     *
     * @return Collection<int, Breadcrumb>
     */
    public function all(): Collection
    {
        return $this->crumbs;
    }

    /**
     * Add a new breadcrumb item.
     */
    public function add(string|array $title, ?string $path = null, array $params = []): static
    {
        $this->crumbs[] = new Breadcrumb($title, $path, $params);

        return $this;
    }

    /**
     * Render a breadcrumbs list.
     */
    public function render(): string
    {
        return print_r($this->crumbs);
    }

    /**
     * Stringify the class instance.
     */
    public function __toString(): string
    {
        return $this->render();
    }
}
