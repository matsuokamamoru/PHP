<?php

/**
 * フォーマット関数
 *
 * @param string or array $params
 * @return string
 */
function smarty_function_vsprintf($params, &$smarty)
{
	if (!isset($params['format']) || !isset($params['values'])) return '';

	if (!is_array($params['values'])) $params['values'] = array($params['values']);

	return vsprintf($params['format'], $params['values']);
}
