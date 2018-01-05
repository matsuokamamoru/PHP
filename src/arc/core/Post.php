<?php

class Post extends RequestVariables
{
	/**
	 * POST変数を設定
	 */
	protected function setValues()
	{
		foreach ($_POST as $key => $value)
		{
			$this->values[$key] = $value;
		}
	}
}