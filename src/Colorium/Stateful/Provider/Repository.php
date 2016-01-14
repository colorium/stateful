<?php

namespace Colorium\Stateful\Provider;

use Colorium\Tools\ArrayDot;

class Repository extends Native
{


    /**
     * Check if value exists in session
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return ArrayDot::has($_SESSION[$this->root], $key);
    }


    /**
     * Get value in session
     *
     * @param string $key
     * @param mixed $fallback
     * @return mixed
     */
    public function get($key, $fallback = null)
    {
        return ArrayDot::get($_SESSION[$this->root], $key, $fallback);
    }


    /**
     * Set value in session
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        ArrayDot::set($_SESSION[$this->root], $key, $value);
    }


    /**
     * Clear value in session
     *
     * @param string $key
     * @return bool
     */
    public function drop($key)
    {
        return ArrayDot::drop($_SESSION[$this->root], $key);
    }

}