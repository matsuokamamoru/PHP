<?php

class Validator
{
	/** 正規表現 **/
	const REGEX_PHONE = "/^([\+][0-9]{1,3}[ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9 \.\-\/]{3,20})((x|ext|extension)[ ]?[0-9]{1,4})?$/";
	const REGEX_PHONE2 = "/^\d{1,4}-\d{4}$|^\d{2,5}-\d{1,4}-\d{4}$/";
	const REGEX_EMAIL = "/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i";
	const REGEX_DATE = "/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/";
	const REGEX_IPV4 = "/^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/";
	const REGEX_URL = "/^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i";
	const REGEX_KANA = '/^[ｱ-ﾝﾞﾟｧ-ｫｬ-ｮｰァ-ヶー\s]+?$/u';
	const REGEX_SPACE = "/^(　|)*|(　|)*$/";
	const REGEX_HARF_CHAR = "/^[!-~]+$/";
	const REGEX_ALPHA_CHAR = "/^([!-~]|)+$/";
	const REGEX_FILE = "/^(?!.*(^.*[(\\|\/|:|\*|?|\"|<|>|\|)].*$))/";

	/**
	 * 文字列のnull、ブランクチェック
	 *
	 * @param array or string $args_data
	 * @return bool true null または ブランク / false null または ブランクでない
	 */
	public static function isNullOrEmpty($args_data)
	{
		if (is_array($args_data))
		{
			foreach ($args_data as $param)
			{
				if(!self::isNullOrEmpty($param)) return false;
			}

			return true;
		}
		elseif (is_null($args_data) || $args_data === '')
		{
			return true;
		}

		return false;
	}

	/**
	 * 文字列のブランクチェック
	 *
	 * @param array or string $args_data
	 * @return bool true ブランク / false ブランクでない
	 */
	public static function isBlankChar($args_data)
	{
		if (is_array($args_data))
		{
			foreach ($args_data as $param)
			{
				if(!self::isBlankChar($param)) return false;
			}

			return true;
		}
		elseif (trim($args_data) === '')
		{
			return true;
		}

		return false;
	}

	/**
	 * 必須チェック
	 *
	 * @param array or string $args_data
	 * @return bool true 必須OK / false 必須NG
	 */
	public static function isRequired($args_data)
	{
		if (is_array($args_data))
		{
			foreach ($args_data as $param)
			{
				if (!self::isRequired($param)) return false;
			}

			return true;
		}
		elseif (mb_strlen(trim($args_data), 'utf-8') > 0)
		{
			return true;
		}

		return false;
	}

	/**
	 * 数値チェック
	 *
	 * @param array or string $args_data
	 * @return bool true 数値OK / false 数値NG
	 */
	public static function isNumeric($args_data)
	{
		if (is_array($args_data))
		{
			foreach ($args_data as $param)
			{
				if (!self::isNumeric($param)) return false;
			}

			return true;
		}
		elseif (is_numeric($args_data))
		{
			return true;
		}

		return false;
	}

	/**
	 * 最小文字数チェック
	 *
	 * @param array or string $args_data
	 * @return bool true 指定した最小文字数より大きい場合 / false 指定した最小文字数より小さい場合
	 */
	public static function isMinLength($min_length, $args_data)
	{
		if (is_array($args_data))
		{
			foreach ($args_data as $param)
			{
				if(!self::isMinLength($min_length, $param)) return false;
			}

			return true;
		}
		elseif ($min_length <= mb_strlen(trim($args_data), 'utf-8'))
		{
			return true;
		}

		return false;
	}

	/**
	 * 最大文字数チェック
	 *
	 * @param array or string $args_data
	 * @return bool true 指定した最大文字数より小さい場合 / false 指定した最大文字数より大きい場合
	 */
	public static function isMaxLength($max_length, $args_data)
	{
		if (is_array($args_data))
		{
			foreach ($args_data as $param)
			{
				if (!self::isMaxLength($max_length, $param)) return false;
			}

			return true;
		}
		elseif (mb_strlen(trim($args_data), 'utf-8') <= $max_length)
		{
			return true;
		}

		return false;
	}

	/**
	 * 最小値チェック
	 *
	 * @param array or string $args_data
	 * @return bool true 指定した最小値より大きい場合 / false 指定した最小値より小さい場合
	 */
	public static function isMinValue($min_data, $args_data)
	{
		if (is_array($args_data))
		{
			foreach ($args_data as $param)
			{
				if (!self::isMinValue($min_data, $param)) return false;
			}

			return true;
		}
		elseif ($min_data <= $args_data)
		{
			return true;
		}

		return false;
	}

	/**
	 * 最大値チェック
	 *
	 * @param array or string $args_data
	 * @return bool true 指定した最大値より小さい場合 / false 指定した最大値より大きい場合
	 */
	public static function isMaxValue($max_data, $args_data)
	{
		if (is_array($args_data))
		{
			foreach ($args_data as $param)
			{
				if (!self::isMaxValue($max_data, $param)) return false;
			}

			return true;
		}
		elseif ($args_data <= $max_data)
		{
			return true;
		}

		return false;
	}

	/**
	 * 正規表現チェック
	 *
	 * @param array or string $args_data
	 * @return bool true 指定した正規表現と一致した場合 / false 指定した正規表現と一致しない場合
	 */
	public static function isRegex($regex, $args_data)
	{
		if (is_array($args_data))
		{
			foreach ($args_data as $param)
			{
				if (! $this->isRegex($regex, $param))
				{
					return false;
				}
			}

			return true;
		}
		elseif (preg_match($regex, $args_data))
		{
			return true;
		}

		return false;
	}

}