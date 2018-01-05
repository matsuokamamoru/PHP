<?php

class SnsModel extends ModelBase
{
	private $_genreList;
	private $_twitter;

	public function __construct()
	{
		parent::__construct();

		$this->_genreList = WrapSpyc::getValueArray('genre');

		$sns_yaml = WrapSpyc::getValueArray('sns');
		$this->_twitter = $sns_yaml['twitter'];
	}

	public function pushTwitter()
	{
		$sql = new SnsSql();

		$data = $sql->findWithin1Hours(10, 0);
		$data = array_merge($data, $sql->findWithinRand(1, 0));

		if (count($data) === 0) return;

		$twtter = new Twitter();
		$twtter->setCsKey($this->_twitter['consumer_key']);
		$twtter->setCsSecret($this->_twitter['consumer_secret']);
		$twtter->setAsToken($this->_twitter['access_token']);
		$twtter->setAsSecret($this->_twitter['access_token_secret']);

		foreach ($data as $item)
		{
			$genre = isset($this->_genreList[$item['genre_id']]) ? $this->_genreList[$item['genre_id']] : '';

			$twtter->sendRequest($item['title'] . ' http://' . DOMAIN_NAME . '/detail/index/' . $item['content_id'] . ' #xvideos #エロ動画 #' . $genre);
		}

	}

}