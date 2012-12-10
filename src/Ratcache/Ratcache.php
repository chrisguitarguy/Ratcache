<?php
/**
 * Ratcache
 *
 * Copyright 2012 Christopher Davis <http://christopherdavis.me>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @package     Ratcache
 * @author      Christopher Davis <http://christopherdavis.me>
 * @copyright   2012 Christopher Davis
 * @license     http://opensource.org/licenses/GPL-2.0 GPL-2.0+
 * @since       0.1
 */

namespace Ratcache;

/**
 * Central Cache object.
 *
 * @author  Christopher Davis <http://christopherdavis.me>
 * @since   0.1
 */
class Ratcache
{
    /**
     * Container for the storage object.
     *
     * @access  protected
     * @var     Store\StoreInterface
     */
    protected $store;

    public function __construct(Storage\StorageInterface $s=null)
    {
        is_null($s) && $s = new Storage\NullStore();
        $this->setStorage($s);
    }

    /**
     * Set the storage engine.
     *
     * @access  public
     * @since   0.1
     * @param   Storage\StorageInterface $s
     * @return  void
     */
    public function setStorage(Storage\StorageInterface $s)
    {
        $this->store = $s;
    }

    /**
     * Get the storage engine
     *
     * @access  public
     * @since   0.1
     * @return  Storage\StorageInterface
     */
    public function getStorage()
    {
        return $this->store;
    }

    /**
     * Add a key to the cache if it doesn't already exist.
     *
     * @access  public
     * @since   0.1
     * @param   string $key The cache key.
     * @param   string $val Value to be cached.
     * @param   int $ttl (optional) How long to cache the value for. This may
     *          not be used by all storage implementations.
     * @return  boolean True on success, false on failure.
     */
    public function add($key, $val, $ttl=3600)
    {
        return $this->getStorage()->add($key, $val, $ttl);
    }

    /**
     * Set a key in the cache. This overwrites already existing keys.
     *
     * @access  public
     * @since   0.1
     * @param   string $key The cache key.
     * @param   string $val Value to be cached.
     * @param   int $ttl (optional) How long to cache the value for. This may
     *          not be used by all storage implementations.
     * @return  boolean True on success, false on failure.
     */
    public function set($key, $val, $ttl=3600)
    {
        return $this->getStorage()->set($key, $val, $ttl);
    }

    /**
     * Increment a cache key by $i.
     *
     * @access  public
     * @since   0.1
     * @param   string $key The cache key
     * @param   int $i (optional) The amount to increment by.
     * @param   int $ttl (optional) How long to cache the value for.
     * @return  boolean|int False on failure, the incremented value on success.
     */
    public function inc($key, $i=1, $ttl=3600)
    {
        return $this->getStorage()->inc($key, $i, $ttl);
    }

    /**
     * Decrement a cache key by $i.
     *
     * @access  public
     * @since   0.1
     * @param   string $key The cache key
     * @param   int $i (optional) The amount to decrement by.
     * @param   int $ttl (optional) How long to cache the value for.
     * @return  boolean|int False on failure, the decremented value on success.
     */
    public function dec($key, $i=1, $ttl=3600)
    {
        return $this->getStorage()->dec($key, $i, $ttl);
    }

    /**
     * Delete a cache key.
     *
     * @access  public
     * @since   0.1
     * @param   string $key The cache key
     * @return  boolean True on success, false on failure
     */
    public function delete($key)
    {
        return $this->getStorage()->delete($key);
    }

    /**
     * Clear the cache.
     *
     * @access  public
     * @since   0.1
     * @return  boolean True on success, false on failure
     */
    public function clear()
    {
        return $this->getStorage()->clear();
    }
}
