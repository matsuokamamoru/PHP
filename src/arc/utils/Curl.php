<?php

class Curl
{
	private static $_instance = null;

	public function __construct()
	{
		if (is_null(self::$_instance))
		{
			self::$_instance = curl_init();
		}
	}

	public function __destruct()
	{
		if (!is_null(self::$_instance))
		{
			curl_close(self::$_instance);
			self::$_instance = null;
		}
	}

	/**
	 * curlオプション指定関数(単一)
	 *
	 * @param string $option
	 * @param string or int $value
	 */
	public function setOption($option, $value)
	{
		curl_setopt(self::$_instance, $option, $value);
	}

	/**
	 * curlオプション指定関数(複数)
	 * key:オプションタイプ, value:設定値の形式で指定してください。
	 *
	 * @param array $options
	 */
	public function setOptions($options)
	{
		foreach ($options as $option => $value)
		{
			$this->setOption($option, $value);
		}
	}

	/**
	 * GETパラメータ付与
	 *
	 * @param string $url
	 * @param array $pieces
	 */
	public static function buildUrl($url, array $pieces)
	{
		if (strpos($url, '?') === false)
		{
			$url .= '?';
		}

		foreach($pieces as $key => $value)
		{
			$url .= urlencode($key) . '=' . urlencode($value) . '&';
		}

		return $url;
	}

	/**
	 * Curlの実行結果をそのまま返す
	 *
	 * @return boolean|mixed
	 */
	public function getContents()
	{
		$result = curl_exec(self::$_instance);

		if (!$result)
		{
			return false;
		}

		return $result;
	}

	/**
	 * Curlの実行結果をPHP配列にして返す
	 *
	 * @return boolean|mixed
	 */
	public function getJsonContents()
	{
		$result = $this->getContents();

		if (!$result)
		{
			return false;
		}

		return json_decode($result, true);
	}

	/**
	 * Curlの実行結果をPHP配列にして返す
	 *
	 * @return boolean|mixed
	 */
	public function getXmlContents()
	{
		$result = $this->getContents();

		if (!$result)
		{
			return false;
		}

		return simplexml_load_string($result);
	}

}