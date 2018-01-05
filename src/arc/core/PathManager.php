<?php

class PathManager
{
	/**
	 * Path of system root directory.
	 *
	 * @var string
	 * @access private static
	 */
	private static $_systemDir;

	/**
	 * Path of application root directory.
	 *
	 * @var string
	 * @access private static
	 */
	private static $_appDir;

	/**
	 * Path of controller directory.
	 *
	 * @var string
	 * @access private static
	 */
	private static $_controllerDir;

	/**
	 * Path of model directory.
	 *
	 * @var string
	 * @access private static
	 */
	private static $_modelDir;

	/**
	 * Path of view root directory.
	 *
	 * @var string
	 * @access private static
	 */
	private static $_viewDir;

	/**
	 * Path of config files directory.
	 *
	 * @var string
	 * @access private static
	 */
	private static $_configDir;

	/**
	 * Path of document root directory.
	 *
	 * @var string
	 * @access private static
	 */
	private static $_htdocsDir;

	/**
	 * Path of directory to output log.
	 *
	 * @var string
	 * @access private static
	 */
	private static $_logDir;

	/**
	 * Set path of system root directory and another directory
	 * application, config, output log, document root, library at the same time set
	 *
	 * @access public static
	 * @param string $path
	 */
	public static function setSystemRoot($path)
	{
		self::$_systemDir = rtrim($path, '/');
		self::setAppDirectory(self::$_systemDir . '/app');
		self::setConfigDirectory(self::$_systemDir . '/configs');
		self::setHtdocsDirectory(self::$_systemDir . '/htdocs');
	}

	/**
	 * Set path of application root directory and another directory
	 * controller, model, view, service at the same time set
	 *
	 * @access public static
	 * @param string $path
	 */
	public static function setAppDirectory($path)
	{
		self::$_appDir = rtrim($path, '/');
		self::setControllerDirectory(self::$_appDir . '/controllers');
		self::setModelDirectory(self::$_appDir . '/models');
		self::setViewDirectory(self::$_appDir . '/views');
	}

	/**
	 * Set path of controller directory
	 *
	 * @access public static
	 * @param string $dir
	 */
	public static function setControllerDirectory($dir)
	{
		self::$_controllerDir = rtrim($dir, '/');
	}

	/**
	 * Set path of model directory
	 *
	 * @access public static
	 * @param string $dir
	 */
	public static function setModelDirectory($dir)
	{
		self::$_modelDir = rtrim($dir, '/');
	}

	/**
	 * Set path of view directory
	 *
	 * @access public static
	 * @param string $dir
	 */
	public static function setViewDirectory($dir)
	{
		self::$_viewDir = rtrim($dir, '/');
	}

	/**
	 * Set path of config file directory
	 *
	 * @access public static
	 * @param string $dir
	 */
	public static function setConfigDirectory($dir)
	{
		self::$_configDir = rtrim($dir, '/');
	}

	/**
	 * Set path of document root directory
	 *
	 * @access public static
	 * @param string $dir
	 */
	public static function setHtdocsDirectory($dir)
	{
		self::$_htdocsDir = rtrim($dir, '/');
	}

	/**
	 * Set path of directory to output log
	 *
	 * @access public static
	 * @param string $dir
	 */
	public static function setLogDirectory($dir)
	{
		self::$_logDir = rtrim($dir, '/');
	}

	/**
	 * Get path of system root directory
	 *
	 * @access public static
	 * @return string
	 */
	public static function getSystemRoot()
	{
		return self::$_systemDir;
	}

	/**
	 * Get path of application root directory
	 *
	 * @access public static
	 * @return string
	 */
	public static function getAppDirectory()
	{
		return self::$_appDir;
	}

	/**
	 * Get path of controller directory
	 *
	 * @access public static
	 * @return string
	 */
	public static function getControllerDirectory()
	{
		return self::$_controllerDir;
	}

	/**
	 * Get path of model directory
	 *
	 * @access public static
	 * @return string
	 */
	public static function getModelDirectory()
	{
		return self::$_modelDir;
	}

	/**
	 * Get path of view root directory
	 *
	 * @access public static
	 * @return string
	 */
	public static function getViewDirectory()
	{
		return self::$_viewDir;
	}

	/**
	 * Get path of config file directory
	 *
	 * @access public static
	 * @return string
	 */
	public static function getConfigDirectory()
	{
		return self::$_configDir;
	}

	/**
	 * Get path of document root directory
	 *
	 * @access public static
	 * @return string
	 */
	public static function getHtdocsDirectory()
	{
		return self::$_htdocsDir;
	}

	/**
	 * Get path of directory to output log
	 *
	 * @access public static
	 * @return string
	 */
	public static function getLogDirectory()
	{
		return self::$_logDir;
	}

}