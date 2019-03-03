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

    public function setUp(): void
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

    public function testItHasTheViewForAResponse()
    {
        $this->assertEquals('foo', $this->response->getView('page'));
    }

    public function testItCanUseDynamicWithMethodsToSetData()
    {
        $this->response->withFoo('bar');

        $this->assertEquals('bar', $this->response->getData('foo'));
    }

    public function testItCanSetAnArrayOfData()
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

    public function testItOnlyAllowsDynamicMethodsForSettingWithData()
    {
        $this->expectException('BadMethodCallException');

        $this->response->foo('foo');
    }
}