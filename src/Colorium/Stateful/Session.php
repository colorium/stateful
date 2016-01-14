<?php

namespace Colorium\Stateful;

abstract class Session
{

	/** @var Provider */
	protected static $provider;

	/** @var string */
	protected static $root = '__DATA__';


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
	 * Check if value exists in session
	 * 
	 * @param string $key 
	 * 
	 * @return bool
	 */
	public static function has($key)
	{
		return static::provider()->has($key);
	}


	/**
	 * Get value in session
	 * 
	 * @param string $key 
	 * @param mixed $fallback 
	 * 
	 * @return mixed
	 */
	public static function get($key, $fallback = null)
	{
		return static::provider()->get($key, $fallback);
	}


	/**
	 * Set value in session
	 * 
	 * @param string $key 
	 * @param mixed $value
	 */
	public static function set($key, $value)
	{
		static::provider()->set($key, $value);
	}


	/**
	 * Clear value in session
	 *
	 * @param string $key 
	 * @return bool
	 */
	public static function drop($key)
	{
		return static::provider()->drop($key);
	}

}