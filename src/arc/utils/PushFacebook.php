<?php
/**
 * 準備：
 * authProcessしてTokenを設定する必要がある。
 * 使い方：
 * $pushFacebook = new PushFacebook();
 * $pushFacebook->setAppId(アプリケーションID); # Facebook Developersより取得した内容を設定
 * $pushFacebook->setApiSecret(APP);            # Facebook Developersより取得した内容を設定
 * $pushFacebook->setUserToken();               # authProcessで出力された内容を設定
 * $pushFacebook->setPagesId();                 # Facebookより取得した内容を設定
 */

class PushFacebook
{
	private $_app_id     = '';
	private $_api_secret = '';
	private $_user_token = '';
	private $_pages_id   = '';
	private $_facebook;

	public function setAppId($app_id)
	{
		$this->_app_id = $app_id;
	}

	public function setApiSecret($api_secret)
	{
		$this->_api_secret = $api_secret;
	}

	public function setUserToken($user_token)
	{
		$this->_user_token = $user_token;
	}

	public function setPagesId($pages_id)
	{
		$this->_pages_id = $pages_id;
	}

	/**
	 * Facebookアプリの連携承認を行うメソッド
	 * ※Facebookアプリとの連携が出来てない場合はこのメソッドを使い、
	 * 　トークンを生成する。
	 */
	public function authProcess()
	{
		header("Content-type: text/html; charset=utf-8");

		// API連携の設定
		if(!isset($this->_facebook))
		{
			$this->createInstance();
		}

		// 認証情報の取得
		$user = $this->_facebook->getUser();

		// 認証出来なかった場合はFacebookのアプリ認証画面へ遷移
		if (!$user)
		{
			$loginUrl = $this->_facebook->getLoginUrl(
					array('canvas'    => 1,
							'fbconnect' => 0,
							'scope'     => 'status_update,publish_stream,manage_pages,offline_access'));

			header('Location:' . $loginUrl );
			exit();
		}

		try
		{
			// 各種トークン情報を取得
			$data = $this->_facebook->api('/me/accounts');
			print_r($data);
		}
		catch (FacebookApiException $e)
		{
			throw $e;
		}
	}

	/**
	 * Facebookの投稿を行う。
	 *
	 *  $data = array(
	 *  'source'  => 画像のURL,
	 *  'link'    => リンク先のURL,
	 *  'name'    => 名前,
	 *  'caption' => 'キャプション2',
	 *  'description' => '説明文',);
	 * ---------------------------------------------------------------
	 * ※Facebookアプリとの連携が出来てない場合はエラーが発生する。
	 * ※リクエストのデータとFacebook側の設定が正しくないとエラーが発生する。
	 */
	public function sendRequest($data)
	{
		// API連携の設定
		if(!isset($this->_facebook))
		{
			$this->createInstance();
		}

		// ユーザトークンの追加
		$requestData = $data + array('access_token' => $this->_user_token);
		$statusUpdate = $this->_facebook->api("/$this->_pages_id/feed", 'post', $requestData);
	}

	/**
	 * Facebookのインスタンス生成
	 */
	private function createInstance()
	{
		$this->_facebook = new Facebook(
				array('appId'  => $this->_app_id,
						'secret' => $this->_api_secret,
						'cookie' => true,));
	}

}