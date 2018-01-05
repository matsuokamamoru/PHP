<?php

class OneTimeToken
{
	private $_session = null;

	public function __construct($session)
	{
		$this->_session = $session;
	}

	/**
	 * @function create
	 * @summary oneTimeTokenを作成する
	 *
	 * @return $token 生成されたトークン
	 */
	public function create()
	{
		// ランダムな文字列を生成
		$token = sha1(uniqid(mt_rand(), true));

		// トークンをセッションに書き込む
		$this->_session->set('token', $token);

		return $token;
	}

	/**
	 * @function createTimeLimited
	 * @summary oneTimeTokenを作成する
	 *
	 * @return $token 生成されたトークン
	 */
	public function createTimeLimited()
	{
		// ランダムな文字列を生成
		$token_data['token']  = sha1(uniqid(mt_rand(), true));
		$token_data['expire'] = (new DateTime())->modify(TOKEN_EXPIRE);

		$this->_session->set('token_limited', $token_data);
		return $token_data['token'];
	}

	/**
	 *
	 * @function isSetLimited
	 * @param String $token
	 * @return boolean
	 */
	public function isSetLimited($token)
	{
		//センションから取得後、トークン破棄
		$before_token = $this->_session->get('token_limited');
		$this->_session->set('token_limited', null);

		$date_time = new DateTime();
		// 有効時間 check
		if ( $before_token['expire'] < $date_time )
		{
			return false;
		}

		if ($token !== $before_token['token'])
		{
			return false;
		}

		return true;
	}

	/**
	 * @function is_set
	 * @summary パラメータのトークンとセッションに格納されたトークンを比較して
	 *          正しいかどうか判定を行う
	 *
	 * @param $token トークン
	 *
	 * @return $result bool
	 *            true:トークンが正しい
	 *            false:トークンが正しくない
	 */
	public function is_set($token)
	{
		$result = false;

		//センションから取得後、トークン破棄
		$before_token = $this->_session->get('token');
		$this->_session->set('token', null);

		if($token === $before_token){
			$result = true;
		}

		return $result;
	}

}