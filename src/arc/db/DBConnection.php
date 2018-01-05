<?php

final class ForbiddenClonePDO extends PDO
{
	public final function __clone()
	{
		throw new RuntimeException('Clone is not allowed against ' . get_class($this));
	}
}

class DBConnection
{
	/** 接続情報 */
	private static $_conf;

	/** 接続情報のフォーマット */
	private static $_dsn = array(
		'mysql' => 'mysql:host=%s;dbname=%s;port=%s',
		'pgsql' => 'pgsql:host=%s dbname=%s port=%s'
	);

	/** PDOオブジェクトのインスタンス */
	private static $_instance;

	private function __construct()
	{
		try
		{
			// 接続情報の生成
			$dsn = sprintf(self::$_dsn[self::$_conf['type']], self::$_conf['host'], self::$_conf['dbname'], self::$_conf['port']);

			// オプションの設定
			$options = array();

			if (self::$_conf['type'] == 'mysql')
			{
				$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . self::$_conf['charset']);
			}

			// インスタンス生成
			self::$_instance = new ForbiddenClonePDO(
				$dsn,
				self::$_conf['user'],
				self::$_conf['password'],
				$options);

			// パラメータを設定
			self::$_instance->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE);
			self::$_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $ex)
		{
			throw $ex;
		}
	}

	/**
	 * PDOオブジェクト取得
	 *
	 */
	public static function getDbh()
	{
		if (!isset(self::$_instance))
		{
			new self();
		}
		return self::$_instance;
	}

	/**
	 * DB接続情報設定
	 *
	 * @param array $conf
	 */
	public static function setConfig(array $conf)
	{
		// 接続できるDB以外が設定された場合
		if (!array_key_exists($conf['type'], self::$_dsn))
		{
			throw new Exception('db type configration is invalid.');
		}

		self::$_conf = $conf;
	}

}