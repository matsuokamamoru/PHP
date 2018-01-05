<?php

class MailMessage
{
	private $_msg;
	private $_msgList;

	public function __construct($path)
	{
		$load_xml = simplexml_load_file($path);

		if($load_xml)
		{
			$this->_msgList = $load_xml;
		}
	}

	/**
	 * メッセージをセット
	 *
	 * @arg : $name
	 * @return :
	 */
	private function set($name)
	{
		$this->_msg = $this->_msgList->$name;
	}

	/**
	 * メッセージ取得
	 *
	 * @arg : $name
	 * @return : $msg
	 */
	public function get($name)
	{
		self::set($name);
		return $this->_msg;
	}
}