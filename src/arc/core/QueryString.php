<?php

class QueryString extends RequestVariables
{
	/**
	 * GET変数を設定
	 */
	protected function setValues()
	{
		foreach ($_GET as $key => $value)
		{
			$this->values[$key] = $value;
		}
	}
}