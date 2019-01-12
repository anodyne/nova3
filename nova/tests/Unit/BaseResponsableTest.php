<?php

namespace Tests\Unit;

use Tests\TestCase;
use Nova\Pages\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nova\Foundation\Http\Responses\BaseResponsable;

class BaseResponsableTest extends TestCase
{
    use RefreshDatabase;

    protected $response;

    public function setUp()
    {
        parent::setUp();

        $page = Page::first();

        $this->response = (new class($page, $this->app) extends BaseResponsable {
            public function views()
            {
                return [
                    'page' => 'foo'
                ];
            }
        });
    }

    /** @test **/
    public function it_has_the_view_for_a_response()
    {
        $this->assertEquals('foo', $this->response->getView('page'));
    }

    /** @test **/
    public function it_can_use_dynamic_with_methods_to_set_data()
    {
        $this->response->withFoo('bar');

        $this->assertEquals('bar', $this->response->getData('foo'));
    }

    /** @test **/
    public function it_can_set_an_array_of_data()
    {
        $this->response->with([
            'foo' => 'foo',
            'bar' => 'bar',
            'baz' => 'baz',
        ]);

        tap($this->response, function ($response) {
            $this->assertEquals('foo', $response->getData('foo'));
            $this->assertEquals('bar', $response->getData('bar'));
            $this->assertEquals('baz', $response->getData('baz'));
        });
    }

    /** @test **/
    public function it_only_allows_dynamic_methods_for_setting_with_data()
    {
        $this->expectException('BadMethodCallException');

        $this->response->foo('foo');
    }
}