<?php

namespace Colorium\Stateful\Provider;

use Colorium\Stateful\Contract;

class Native implements Contract\ProviderInterface
{

    /** @var string */
    protected $root;


    /**
     * Setup native session
     *
     * @param string $root
     */
    public function __construct($root)
    {

        if(!session_id() and !headers_sent()) {
            ini_set('session.use_trans_sid', 0);
            ini_set('session.use_only_cookies', 1);
            ini_set("session.cookie_lifetime", 604800);
            ini_set("session.gc_maxlifetime", 604800);
            session_set_cookie_params(604800);
            session_start();
        }

        $this->root = $root;
        if(!isset($_SESSION[$this->root])) {
            $_SESSION[$this->root] = [];
        }
    }


    /**
     * Check if value exists in session
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return isset($_SESSION[$this->root][$key]);
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
        return $this->has($key)
            ? $_SESSION[$this->root][$key]
            : $fallback;
    }


    /**
     * Set value in session
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $_SESSION[$this->root][$key] = $value;
    }


    /**
     * Clear value in session
     *
     * @param string $key
     * @return bool
     */
    public function drop($key)
    {
        if($this->has($key)) {
            unset($_SESSION[$this->root][$key]);
            return true;
        }

        return false;
    }

}