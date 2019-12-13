<?php

namespace OmerKamcili\Pagination\Test;

use OmerKamcili\Pagination\Pagination;
use PHPUnit\Framework\TestCase;

/**
 * Class PaginationTest
 * @package OmerKamcili\Pagination\Test
 */
class PaginationTest extends TestCase
{

    /**
     * @throws \Exception
     */
    public function testPagination()
    {

        $params = [
            'total' => 103,
            'skip'  => 20,
            'url'   => 'http:://api.foo.bar/',
        ];

        $instance = new Pagination($params);

        $this->assertInstanceOf(Pagination::class, $instance);
        $this->assertEquals($params['total'], $instance->total);
        $this->assertEquals(6, count($instance->pages));
        $this->assertEquals(11, $instance->totalPages);
        $this->assertEquals(3, $instance->currentPage);
        $this->assertEquals('http:://api.foo.bar/?take=10&skip=0', $instance->pages[1]);
        $this->assertEquals('http:://api.foo.bar/?take=10&skip=10', $instance->pages[2]);
        $this->assertEquals('http:://api.foo.bar/?take=10&skip=20', $instance->pages[3]);
        $this->assertEquals('http:://api.foo.bar/?take=10&skip=30', $instance->pages[4]);
        $this->assertEquals('http:://api.foo.bar/?take=10&skip=40', $instance->pages[5]);
        $this->assertEquals('http:://api.foo.bar/?take=10&skip=50', $instance->pages[6]);

    }

}