<?php

class Ini
{
	/**
	 * Read ini file and return values as array
	 *
	 * @param string $fileName The name of the ini file to read
	 * @param string $section If the section name you want to get only certain sections
	 */
	public static function load($fileName, $section = null)
	{
		$ret = false;
		$path = PathManager::getConfigDirectory() . $fileName;

		if (file_exists($path))
		{
			$iniArray = parse_ini_file($path, true);
			if ($section != null)
			{
				$iniArray = $iniArray[$section];
				$ret = self::_levelize($iniArray);
			}
			else
			{
				foreach ($iniArray as $sec => $values)
				{
					$ret[$sec] = self::_levelize($values);
				}
			}
		}
		return $ret;
	}

	private static function _levelize($iniArray)
	{
		$ret = array();
		$prev = array();
		foreach ($iniArray as $key => $value)
		{
			if (strpos($key, '.') !== false)
			{
				$keyParts = explode('.', $key);
				$levelized = array();

				for ($i = count($keyParts) - 1; $i >= 0; $i--)
				{
					$keyPart = $keyParts[$i];
					if ($i == count($keyParts) - 1)
					{
						$levelized[$keyPart] = $value;
					}
					else
					{
						$tmp = array();
						$tmp[$keyPart] = $levelized;
						$levelized = $tmp;
					}
				}

				$ret = array_merge_recursive($prev, $levelized);
				$prev = $ret;
			}
			else
			{
				$ret[$key] = $value;
			}
		}

		return $ret;
	}
}