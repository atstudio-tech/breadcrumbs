<?php

namespace ATStudio\Breadcrumbs\Tests;

use ATStudio\Breadcrumbs\Breadcrumbs;
use ATStudio\Breadcrumbs\Exceptions\InvalidBreadcrumbOptions;
use ATStudio\Breadcrumbs\Facades\Crumbs;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class BreadcrumbsTest extends TestCase
{
    /** @test */
    public function it_returns_a_class_singleton()
    {
        $this->assertInstanceOf(Breadcrumbs::class, crumbs());
        $this->assertInstanceOf(Breadcrumbs::class, Breadcrumbs::instance());
        $this->assertSame(crumbs(), Breadcrumbs::instance());
    }

    /** @test */
    public function it_accepts_a_title_only_and_path_is_inferred()
    {
        URL::shouldReceive('current')->andReturn('/main-section');

        Crumbs::add('Main Section');

        $this->assertEquals('/main-section', crumbs()->all()->first()->path);
    }

    /** @test */
    public function it_accepts_a_title_and_a_path()
    {
        Breadcrumbs::instance()
            ->add('Main Section', '/main')
            ->add('Last Section', '/main/last');

        $this->assertCount(2, Crumbs::all());
        $this->assertEquals('Main Section', crumbs()->all()->first()->title);
        $this->assertEquals('Last Section', crumbs()->all()->last()->title);
        $this->assertEquals('http://localhost/main', crumbs()->all()->first()->path);
    }

    /** @test */
    public function it_accepts_a_route_name()
    {
        $this->mockRoutes();

        Crumbs::add('All Posts', 'posts.index');

        $this->assertEquals('http://localhost/posts', crumbs()->all()->first()->path);
    }

    /** @test */
    public function it_accepts_route_parameters()
    {
        $this->mockRoutes();

        Crumbs::add('Show Post #1', 'posts.show', [1]);
        Crumbs::add('Show Post #2', 'posts.show', ['post' => 2]);

        $this->assertEquals('http://localhost/posts/1', crumbs()->all()->first()->path);
        $this->assertEquals('http://localhost/posts/2', crumbs()->all()->last()->path);
    }

    /** @test */
    public function it_validates_options_array()
    {
        $this->expectException(InvalidBreadcrumbOptions::class);

        crumbs([
            'name' => 'Invalid key',
        ]);
    }

    /** @test */
    public function it_accepts_an_array_of_options()
    {
        crumbs([
            'title' => 'About Page',
            'path' => '/about',
        ]);

        $this->assertEquals('About Page', crumbs()->all()->first()->title);
        $this->assertEquals('http://localhost/about', crumbs()->all()->first()->path);
    }

    /** @test */
    public function it_accepts_an_array_of_options_with_a_route_name()
    {
        $this->mockRoutes();

        crumbs([
            'title' => 'Post',
            'path' => 'posts.show',
            'params' => [10],
        ]);

        $this->assertEquals('http://localhost/posts/10', crumbs()->all()->first()->path);
    }

    /** @test */
    public function it_accepts_a_closure()
    {
        crumbs(function (Breadcrumbs $crumbs) {
            $crumbs
                ->add('Main Page', '/main')
                ->add('Sub Page', '/main/sub')
                ->add('Current Page', '/main/sub/current');
        });

        $this->assertCount(3, Crumbs::all());
        $this->assertEquals('Main Page', crumbs()->all()->first()->title);
        $this->assertEquals('Current Page', crumbs()->all()->last()->title);
    }

    private function mockRoutes(): void
    {
        $collection = new RouteCollection();
        $collection->add(Route::get('/posts', fn() => 'all posts')->name('posts.index'));
        $collection->add(Route::get('/posts/{post}', fn($post) => 'post #'.$post)->name('posts.show'));

        Route::shouldReceive('has')->andReturn(true);
        Route::shouldReceive('getRoutes')->andReturn($collection);
    }
}


/*

crumbs(function ($crumbs) {
    $crumbs->add(...)
    $crumbs->add(...)
    $crumbs->add(...)
})

*/
