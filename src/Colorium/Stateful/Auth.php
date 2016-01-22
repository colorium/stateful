<?php

namespace Colorium\Stateful;

use Colorium\Stateful\Contract\ProviderInterface;

abstract class Auth
{

    /** @var ProviderInterface */
    protected static $provider;

    /** @var \Closure */
    protected static $factory;

    /** @var object */
    protected static $user;

    /** @var string */
    protected static $root = '__AUTH__';


    /**
     * Load session provider
     *
     * @param ProviderInterface $provider
     * @return ProviderInterface
     */
    public static function provider(ProviderInterface $provider = null)
    {
        if($provider) {
            static::$provider = $provider;
        }
        elseif(!static::$provider) {
            static::$provider = new provider\Native(static::$root);
        }

        return static::$provider;
    }


    /**
     * Set user factory
     *
     * @param \Closure $factory
     */
    public static function factory(\Closure $factory)
    {
        static::$factory = $factory;
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
     * Get user ref
     *
     * @return string
     */
    public static function ref()
    {
        return static::provider()->get('ref');
    }


    /**
     * Get user object
     *
     * @return object
     */
    public static function user()
    {
        if(!static::$user and static::$factory) {
            static::$user = call_user_func(static::$factory, static::ref());
        }

        return static::$user;
    }


    /**
     * Log user in session
     *
     * @param int $rank
     * @param string $ref
     */
    public static function login($rank = 1, $ref = null)
    {
        static::provider()->set('rank', $rank);
        static::provider()->set('ref', $ref);
    }


    /**
     * Log user out of session
     */
    public static function logout()
    {
        static::provider()->drop('rank');
        static::provider()->drop('ref');
    }

}