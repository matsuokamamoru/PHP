<?php

class UrlParameter extends RequestVariables
{
	/**
	 * パラメータ値設定
	 */
	protected function setValues()
	{
		$params = array();
		if ('' != $_SERVER['REQUEST_URI'])
		{
			// パラメーターを"/"で分割
			$params = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
		}

		// 定義した値分、要素を削除
		$shift = DISPATCHER_SHIFT;
		for ($i = 1; $i <= $shift; $i++)
		{
			array_shift($params);
		}

		// コントローラ、アクション以外のパラメータがない場合
		if (count($params) < 3)
		{
			return;
		}

		// urlパラメータのyml取得
		$urlYaml = WrapSpyc::getValueArray('url');

		$keyList  = null;

		// ymlに定義していない場合、defalutを使用する
		if (isset($urlYaml[$params[0]][$params[1]]))
		{
			$keyList = $urlYaml[$params[0]][$params[1]];
		}
		else
		{
			$keyList = $urlYaml['defalut']['defalut'];
		}

		// コントローラ、アクションのパラメータを削除
		array_shift($params);
		array_shift($params);

		for ($i = 0; $i < count($params); $i++)
		{
			// ymlに設定しているリストの数より小さい場合
			if ($i < count($keyList))
			{

				$key = $keyList[$i];
				$val = $params[$i];
				$this->values[$key] = $val;
			}
		}

	}

}