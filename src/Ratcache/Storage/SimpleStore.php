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

namespace Ratcache\Storage;

/**
 * Cache that lasts for the lifetime of a simple pageload -- Same as using an
 * array to store things, basically.
 *
 * @author  Christopher Davis <http://christopherdavis.me>
 * @since   0.1
 */
class SimpleStore implements StorageInterface
{
    private $store = array();

    /**
     * {@inheritdoc}
     */
    public function get($key, $default='')
    {
        $rv = isset($this->store[$key]) ? $this->store[$key] : $default;

        // people don't expect objects in the cache to change, I would guess.
        if(is_object($rv))
            $rv = clone $rv;

        return $rv;
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $val, $ttl=3600)
    {
        if(!isset($this->store[$key]))
            return $this->set($key, $val, $ttl);

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $val, $ttl=3600)
    {
        if(is_object($val))
            $val = clone $val;

        $this->store[$key] = $val;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function inc($key, $i=1, $ttl=3600)
    {
        $i = $this->validateInt($i);

        if(!$i)
            return false;

        if(!isset($this->store[$key]))
            $this->set($key, 0, $ttl);

        $this->store[$key] += $i;

        return $this->store[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function dec($key, $i=0, $ttl=3600)
    {
        $i = $this->validateInt($i);

        if(!$i)
            return false;

        if(!isset($this->store[$key]))
            $this->set($key, 0, $ttl);

        $this->store[$key] -= $i;

        return $this->store[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key)
    {
        $rv = false;

        if(isset($this->store[$key]))
        {
            unset($this->store[$key]);
            $rv = true;
        }

        return $rv;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->store = array();
        return true;
    }

    private function validateInt($i)
    {
        return abs(intval($i));
    }
}
