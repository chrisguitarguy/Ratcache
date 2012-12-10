<?php

use Ratcache\Ratcache;

class NullStoreTest extends PHPUnit_Framework_TestCase
{
    private $catch;

    public function setUp()
    {
        $this->cache = new Ratcache();
    }

    public function testAddReturnsFalse()
    {
        $this->assertFalse($this->cache->add('foo', 'bar'));
    }

    public function testSetReturnsFalse()
    {
        $res = $this->cache->set('foo', 'bar');

        $this->assertFalse($res);
    }

    public function testIncrementReturnsIncrementValue()
    {
        $res = $this->cache->inc('foo', 1);
        return $this->assertEquals($res, 1);
    }

    public function testIncrementReturnsIncrementValueAgain()
    {
        $res = $this->cache->inc('foo', 5);
        return $this->assertEquals($res, 5);
    }

    public function testDecrementReturnDecrementValue()
    {
        $res = $this->cache->dec('foo', 1);
        $this->assertEquals($res, -1);
    }

    /**
     * @depends testSetReturnsFalse
     */
    public function testDeleteReturnsFalse()
    {
        $this->cache->set('foo', 'bar');
        $this->assertFalse($this->cache->delete('foo'));
    }

    public function testClearReturnsFalse()
    {
        $this->assertFalse($this->cache->clear());
    }
}
