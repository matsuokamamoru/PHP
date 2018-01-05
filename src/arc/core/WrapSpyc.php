<?php

class WrapSpyc
{
	private static $yml_cache = array();
	private static $yml_data = '';

	private static function _doLoadingYML($arg)
	{
//TODO::PATH指定は、独自で行ってください。
		$ymlName = PathManager::getConfigDirectory() . '/yml/' . $arg . '.';
		$dirYmlCache = sprintf('%s/yml_c/', PathManager::getViewDirectory());

		// アプリケーションキャッシュ。
		if(!array_key_exists($ymlName, self::$yml_cache))
		{
			$filename = $ymlName . 'yml';
			$cacheFileName = $dirYmlCache . md5($filename);

			if(self::_isCached($dirYmlCache, $filename, $cacheFileName))
			{
				self::$yml_cache[$ymlName] = self::getData($dirYmlCache, $filename, $cacheFileName);
			}
			else
			{
				self::$yml_cache[$ymlName] = self::_store($filename, $cacheFileName);
			}
		}

		self::$yml_data = self::$yml_cache[$ymlName];
	}

	public static function getData($dir_cache, $filename, $cache_filename)
	{
		return self::_isCached($dir_cache, $filename, $cache_filename) ? self::_load($cache_filename) : self::_store($filename, $cache_filename);
	}

	private static function _isCached($dir_cache, $filename, $cache_filename)
	{
		clearstatcache();
		return file_exists($cache_filename) && (filemtime($filename) <= filemtime($cache_filename));
	}

	private static function _load($cache_filename)
	{
		return unserialize(file_get_contents($cache_filename));
	}

	private static function _store($filename, $cache_filename)
	{
		$data = Spyc::YAMLLoad($filename);
		if(!file_put_contents($cache_filename, serialize($data))) throw new Exception('cache yml書き込み失敗');
		return $data;
	}

	/**
	 * データ取得
	 * [引数一覧]
	 * 1.string YML名
	 * 2.string YML階層(複数指定可)
	 */
	public static function getValueAll()
	{
		$args = func_get_args();

		$ymlName = array_shift($args);
		if(is_null($ymlName)) return false;

		self::_doLoadingYML($ymlName);

		return self::_searchYmlData($args);
	}

	/**
	 * getValueAllのラッパー
	 * [引数一覧]
	 * 1.string YML名
	 * 2.arrray YML階層
	 */
	public static function getAllByArray($ymlName, $args)
	{
		array_unshift($args, $ymlName);
		return call_user_func_array('self::getValueAll', $args);
	}

	/**
	 * データ取得(文字列のみ)
	 * 文字列置換可
	 * [引数一覧]
	 * 1.string YML名
	 * 2.string YML階層(複数指定可)
	 * 3.array  置換用データ配列(未指定可)
	 */
	public static function getValueText()
	{
		$args = func_get_args();

		$ymlName = array_shift($args);
		if(is_null($ymlName)) return false;

		self::_doLoadingYML($ymlName);

		$bind =  array();
		if(is_array(end($args)))
		{
			$bind = array_pop($args);
		}

		$ymlData = self::_searchYmlData($args);
		if($ymlData === false || is_array($ymlData))
		{
			return false;
		}

		return (string)self::_permutationMsg($ymlData, $bind);
	}

	/**
	 * データ取得(配列のみ)
	 * [引数一覧]
	 * 1.string YML名
	 * 2.string YML階層(複数指定可)
	 *
	 * [返り値]
	 * 配列の場合   ⇒ 配列
	 * 文字列の場合 ⇒ array('文字列')に変換
	 * 無い場合     ⇒ array();
	 */
	public static function getValueArray()
	{
		$args = func_get_args();

		$ymlName = array_shift($args);
		if(is_null($ymlName)) return false;

		self::_doLoadingYML($ymlName);

		$ymlData = self::_searchYmlData($args);

		if($ymlData === false) return array();
		if(!is_array($ymlData)) $ymlData = array($ymlData);

		return $ymlData;
	}

	/**
	 * YAMLから取得した文言を置換する
	 *
	 * @param unknown_type $err_msg 置換前エラーメッセージ
	 * @param unknown_type $param   置換対象文字列
	 * Ex. permutationErrMsg('%1$sは文言です。', array('置換文字列1'))
	 */
	private static function _permutationMsg($err_msg, array $param)
	{
		if(!$param) return $err_msg;

		// 入力された置換
		$err_msg = vsprintf($err_msg, $param);

		return $err_msg;
	}

	private static function _searchYmlData($args)
	{
		$ymlData = self::$yml_data;

		foreach($args as $keyName)
		{
			if(!isset($ymlData[$keyName])) return false;
			$ymlData = $ymlData[$keyName];
		}

		return $ymlData;
	}

}