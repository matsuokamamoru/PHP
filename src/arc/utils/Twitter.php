<?php
/**
 * PEARのOAuthをインストールする必要があります。
 *
 * ※Windows環境の場合はphp.iniに下記を追加
 * 　extension=php_openssl.dll
 *
 * 準備：
 * https://dev.twitter.com/ にアクセスしてCreate an appを生成する
 * 使い方：
 * 	$twtter =new Twitter();
 * 	$twtter->setCsKey(※Consumer key);
 * 	$twtter->setCsSecret(※Consumer secret);
 * 	$twtter->setAsToken(※Access token);
 * 	$twtter->setAsSecret(※Access token secret);
 * 	$twtter->sendRequest('ツイートしたいメッセージ');
 */

class Twitter
{

	private $_cs_key    = '';
	private $_cs_secret = '';
	private $_as_token  = '';
	private $_as_secret = '';
	private $_request_token = 'https://api.twitter.com/oauth/request_token';
	private $_callback_url  = '';
	private $_oauth;
	private $_http_request;
	private $_oauth_request;

	public function __construct()
	{
		require_once ('HTTP/OAuth/Consumer.php');
		// ssl証明書
		$this->_http_request = new HTTP_Request2();
		$this->_http_request->setConfig('ssl_verify_peer', false);
		$this->_oauth_request = new HTTP_OAuth_Consumer_Request;
		$this->_oauth_request->accept($this->_http_request);
	}

	public function setCsKey($cs_key)
	{
		$this->_cs_key = $cs_key;
	}

	public function setCsSecret($cs_secret)
	{
		$this->_cs_secret = $cs_secret;
	}

	public function setAsToken($as_token)
	{
		$this->_as_token = $as_token;
	}

	public function setAsSecret($as_secret)
	{
		$this->_as_secret = $as_secret;
	}

	public function sendRequest($msg)
	{
		// API連携の設定
		if(!isset($this->_oauth))
		{
			$this->_oauth = new HTTP_OAuth_Consumer($this->_cs_key, $this->_cs_secret);
			$this->_oauth->accept($this->_oauth_request);
			$this->_oauth->getRequestToken($this->_request_token, $this->_callback_url);
			$this->_oauth->setToken($this->_as_token);
			$this->_oauth->setTokenSecret($this->_as_secret);
		}

		// メッセージの送信
		$response = $this->_oauth->sendRequest("https://api.twitter.com/1.1/statuses/update.json", array('status' => $msg), "POST");

	}
}