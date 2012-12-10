<?php

use Ratcache\Ratcache;
use Ratcache\Storage\SimpleStore;

class SimpleStoreTest extends PHPUnit_Framework_TestCase
{
    public function testAddReturnsTrue()
    {
        $c = new RatCache(new SimpleStore());
        $res = $c->add('foo', 'bar');
        $this->assertTrue($res);
    }

    /**
     * Make sure add works first...
     *
     * @depends testAddReturnsTrue
     */
    public function testAddFailsWithSameKey()
    {
        $c = new RatCache(new SimpleStore());
        $c->add('foo', 'bar');

        $this->assertFalse($c->add('foo', 'again'));
    }

    public function testSetReturnsTrue()
    {
        $c = new RatCache(new SimpleStore());
        $this->assertTrue($c->set('foo', 'bar'));
    }

    /**
     * Make sure set works first.
     *
     * @depends testSetReturnsTrue
     */
    public function testSetOverwritesVariables()
    {
        $c = new RatCache(new SimpleStore());
        $c->add('foo', 'bar');
        $this->assertTrue($c->set('foo', 'another value'));
    }

    public function testGetReturnsDefaultForNonexistKey()
    {
        $c = new RatCache(new SimpleStore());
        $this->assertSame($c->get('foo', 'the default'), 'the default');
    }

    /**
     * @depends testSetReturnsTrue
     */
    public function testGetReturnsInsertedValue()
    {
        $c = new RatCache(new SimpleStore());
        $c->set('foo', 'bar');
        $this->assertSame($c->get('foo'), 'bar');
    }

    public function testIncrementReturnsFalseForBadAmount()
    {
        $c = new RatCache(new SimpleStore());
        $this->assertFalse($c->inc('foo', 0));
    }

    public function testIncrementReturnsIncrementedValue()
    {
        $c = new RatCache(new SimpleStore());

        $i = $c->inc('foo');
        $this->assertEquals($i, 1);

        $i = $c->inc('foo');
        $this->assertEquals($i, 2);
    }

    public function testDecrementReturnsFalseForBadAmount()
    {
        $c = new RatCache(new SimpleStore());
        $this->assertFalse($c->dec('foo', 0));
    }

    public function testDecrementReturnsDecrementedValue()
    {
        $c = new RatCache(new SimpleStore());

        $i = $c->dec('foo');
        $this->assertEquals($i, -1);

        $i = $c->dec('foo');
        $this->assertEquals($i, -2);
    }

    public function testObjectsGetClonedWhenRetrievedFromCache()
    {
        $val = new stdClass();

        $c = new RatCache(new SimpleStore());

        $c->set('foo', $val);

        $res = $c->get('foo');

        // did the right class come back?
        $this->assertInstanceOf('stdClass', $res);

        // are they the same?
        $this->assertNotSame($res, $val);
    }

    public function testDeleteReturnFalseForBadKey()
    {
        $c = new RatCache(new SimpleStore());
        $this->assertFalse($c->delete('foo'));
    }

    /**
     * @depends testSetReturnsTrue
     */
    public function testDeleteReturnsTrueForExistingKey()
    {
        $c = new RatCache(new SimpleStore());
        $c->set('foo', 'bar');
        $this->assertTrue($c->delete('foo'));
    }

    public function testClearReturnsTrue()
    {
        $c = new RatCache(new SimpleStore());
        $this->assertTrue($c->clear());
    }
}
