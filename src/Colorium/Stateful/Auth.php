<?php

namespace Colorium\Stateful;

abstract class Auth
{

    /** @var Provider */
    protected static $provider;

    /** @var string */
    protected static $root = '__AUTH__';


    /**
     * Load session provider
     *
     * @param Provider $provider
     * @return Provider
     */
    public static function provider(Provider $provider = null)
    {
        if($provider) {
            static::$provider = $provider;
        }
        elseif(!static::$provider) {
            static::$provider = new Provider\Native(static::$root);
        }

        return static::$provider;
    }


    /**
     * Get user rank
     *
     * @return int
     */
    public static function rank()
    {
        return static::provider()->get('rank', 0);
    }


    /**
     * Get user object
     *
     * @return object
     */
    public static function user()
    {
        return static::provider()->get('user');
    }


    /**
     * Log user in session
     *
     * @param int $rank
     * @param object $user
     */
    public static function login($rank = 1, $user = null)
    {
        static::provider()->set('rank', $rank);
        static::provider()->set('user', $user);
    }


    /**
     * Log user out of session
     */
    public static function logout()
    {
        static::provider()->drop('rank');
        static::provider()->drop('user');
    }

}