<?php

class SqlHelper
{
	private function __construct()
	{
	}

	/**
	 * 引数がブランクの場合はnullを返却
	 *
	 * @param string $val
	 * @return string $val or null
	 */
	public static function emptyToNull($val)
	{
		if ($val === '')
		{
			return null;
		}

		return $val;
	}
}