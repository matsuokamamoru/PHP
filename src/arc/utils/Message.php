<?php

class Message
{
	/**
	 * メッセージ取得
	 *
	 * @param string $key
	 * @param array $param
	 * @return メッセージ
	 */
	public static function get($key, array $param = null)
	{
		$result = null;

		if(is_null($param))
		{
			$result = WrapSpyc::getValueText('msg', $key);
		}
		else
		{
			$result = WrapSpyc::getValueText('msg', $key, $param);
		}

		return $result;
	}

}