<?php

class Session
{
	/** セッションキー  */
	private $_key = '';

	/**
	 * コンストラクタ：指定したセッションキー名でセッションクラスを操作する
	 *
	 * @param string $key
	 */
	public function __construct($key)
	{
		$this->_key = $key;

		if (!isset($_SESSION))
		{
			session_start();
		}
	}

	/**
	 * セッションの存在判定
	 *
	 * @return boolean
	 */
	public function is_set()
	{
		if (isset($_SESSION[$this->_key]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * セッション取得：指定したキー
	 *
	 * @param string $name
	 * @return セッション値
	 */
	public function get($name)
	{
		if (isset($_SESSION[$this->_key][$name]))
		{
			return $_SESSION[$this->_key][$name];
		}
		else
		{
			return null;
		}
	}

	/**
	 * セッション設定：指定したキー
	 *
	 * @param string $name
	 * @param unknown_type $val
	 */
	public function set($name, $val)
	{
		$_SESSION[$this->_key][$name] = $val;
	}

	/**
	 * セッション取得
	 *
	 * @return セッション値
	 */
	public function getList()
	{
		if (isset($_SESSION[$this->_key]))
		{
			return $_SESSION[$this->_key];
		}
		else
		{
			return null;
		}
	}

	/**
	 * セッション設定
	 *
	 * @param array $list
	 */
	public function setList(array $list)
	{
		$_SESSION[$this->_key] = $list;
	}

	/**
	 * セッションID取得
	 *
	 * @return セッションID
	 */
	public function getSessionId()
	{
		return session_id();
	}

	/**
	 * セッションID再発行
	 */
	public function regenerate()
	{
		$data = $this->getList();

		session_regenerate_id(true);

		if (is_null($data))
		{
			$data = array();
		}

		$this->setList($data);
	}

	/**
	 * セッション破棄 ※明示的に呼んで破棄してください。
	 */
	public function dispose()
	{
		$_SESSION[$this->_key] = array();
		session_destroy();
		$this->regenerate();
	}

}