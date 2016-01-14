<?php

namespace Colorium\Stateful;

interface Provider
{

    /**
     * Check if value exists in session
     *
     * @param string $key
     * @return bool
     */
    public function has($key);

    /**
     * Get value in session
     *
     * @param string $key
     * @param mixed $fallback
     * @return mixed
     */
    public function get($key, $fallback = null);

    /**
     * Set value in session
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value);

    /**
     * Clear value in session
     *
     * @param string $key
     * @return bool
     */
    public function drop($key);

}