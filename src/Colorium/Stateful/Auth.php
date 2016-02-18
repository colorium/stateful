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
            static::$provider = new Provider\Native(static::$root);
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
     * Get validity
     *
     * @return bool
     */
    public static function valid()
    {
        return static::provider()->get('valid', false);
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
        if(!static::$user and static::$factory) {
            $id = static::provider()->get('id');
            static::$user = call_user_func(static::$factory, $id);
        }

        return static::$user;
    }


    /**
     * Log user in session
     *
     * @param int $rank
     * @param string $id
     * @return object
     */
    public static function login($rank = 1, $id = null)
    {
        static::provider()->set('valid', true);
        static::provider()->set('rank', $rank);
        static::provider()->set('id', $id);

        return static::user();
    }


    /**
     * Log user out of session
     */
    public static function logout()
    {
        static::provider()->drop('valid');
        static::provider()->drop('rank');
        static::provider()->drop('id');
    }

}