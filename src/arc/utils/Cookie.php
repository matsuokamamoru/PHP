<?php

class Cookie
{
	private $_expire = 0;
	private $_path = '/';

	public function setExpire($timestamp)
	{
		$this->_expire = $timestamp;
	}

	public function setExpireDays($days)
	{
		$this->_expire = $days * 24 * 60 * 60 + time();
	}

	public function setPath($path)
	{
		$this->_path = $path;
	}

	public function set($key, $value)
	{
		setcookie($key, $value, $this->_expire, $this->_path);
	}

	public function get($key)
	{
		return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
	}

	public function remove($key)
	{
		setcookie($key, '', time() - 3600, $this->_path);
	}

}