<?php

/**
 * 入力エラー
 *
 * @param string or array $params
 * @return string
 */
function smarty_function_parts_error($params, &$smarty)
{
	$result = '';

	if (!isset($params['error']) || !isset($params['key'])) return $result;

	foreach ($params['error'] as $key => $value)
	{
		if (isset($value[$params['key']]))
		{
			$result = '<p class="error">' . $value[$params['key']] . '</p>';
			break;
		}
	}

	return $result;
}
