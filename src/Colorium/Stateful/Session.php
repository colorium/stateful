<?php

namespace Colorium\Stateful;

use Colorium\Stateful\Contract\ProviderInterface;

abstract class Session
{

	/** @var ProviderInterface */
	protected static $provider;

	/** @var string */
	protected static $root = '__DATA__';


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