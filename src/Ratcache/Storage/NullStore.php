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
 * Values go in, but they don't come out. This storage engine does nothing but
 * pretend to work.
 *
 * @author  Christopher Davis <http://christopherdavis.me>
 * @since   0.1
 */
class NullStore implements StorageInterface
{
    /**
     * {@inheritdoc}
     */
    public function add($key, $value, $ttl=3600)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $val, $ttl=3600)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function inc($key, $i=1, $ttl=3600)
    {
        return abs(intval($i));
    }

    /**
     * {@inheritdoc}
     */
    public function dec($key, $i=1, $ttl=3600)
    {
        return 0 - abs(intval($i));
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key)
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        return false;
    }
}
