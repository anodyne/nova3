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

        $this->response = (new class($page = Page::first(), $this->app) extends BaseResponsable {
            public function views()
            {
                return [
                    'page' => 'foo',
                ];
            }
        });
    }

    /**
     * @test
     */
    public function itHasResponseView()
    {
        $this->assertEquals('foo', $this->response->getView('page'));
    }

    /**
     * @test
     */
    public function itCanUseDynamicWithMethodsToSetData()
    {
        $this->response->withFoo('bar');

        $this->assertEquals('bar', $this->response->getData('foo'));
    }

    /**
     * @test
     */
    public function itCanSetAnArrayOfData()
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

    /**
     * @test
     */
    public function itOnlyAllowsDynamicMethodsForSettingWithData()
    {
        $this->expectException('BadMethodCallException');

        $this->response->foo('foo');
    }
}
