<?php

namespace Colorium\Stateful;

abstract class Flash extends Session
{

	/** @var string */
	protected static $root = '__FLASH__';


	/**
	 * Consume value in session
	 * 
	 * @param string $key 
	 * @param mixed $fallback 
	 * 
	 * @return mixed
	 */
	public static function get($key, $fallback = null)
	{
		$message = static::provider()->get($key, $fallback);
		static::provider()->drop($key);
		return $message;
	}

}