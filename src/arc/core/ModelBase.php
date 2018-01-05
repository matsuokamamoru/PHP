<?php

abstract class ModelBase
{
	public $siteType = SITE_TYPE_PC;

	protected $session = null;
	protected $oneTimeToken = null;

	public function __construct()
	{
		$this->_setConfig();

		$this->session = new Session(SESSION_KEY);
		$this->oneTimeToken = new OneTimeToken($this->session);
	}

	public function createTimeLimitedToken()
	{
		return $this->oneTimeToken->createTimeLimited();
	}

	/**
	 * スマホ判定 ※レイアウトがスマホの場合、true
	 *
	 * @return bool
	 */
	protected function isViewSP()
	{
		$mview = (new Cookie())->get('mview');

		if ($this->siteType === SITE_TYPE_SP && ((is_null($mview) || $mview === 'off')))
		{
			return true;
		}

		return false;
	}

	/**
	 * DB接続情報設定
	 *
	 */
	private function _setConfig()
	{
		// DB接続情報のyml取得後、コネクションクラスに設定
		$dbYaml = WrapSpyc::getValueArray('db');
		DBConnection::setConfig($dbYaml);
	}

}