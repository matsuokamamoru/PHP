<?php

abstract class AbstractCreateModel extends ModelBase
{
	private $_sessionKey = null;

	public function __construct($sessionKey)
	{
		parent::__construct();
		$this->_sessionKey = $sessionKey;
	}

	public function destroySession()
	{
		$this->session->set($this->_sessionKey,array());
	}

	public function setSession($data)
	{
		$this->session->set($this->_sessionKey, $data);
	}

	public function getSession()
	{
		return $this->session->get($this->_sessionKey);
	}

	protected function setCommonData(&$data)
	{
		// セッションからユーザー名取得
		$session = $this->session->get(AuthModel::SESSION_KEY);
		$data['create_person'] = $session['mem_name'];
		$data['update_person'] = $session['mem_name'];
	}

	protected function validate($data)
	{
		$result = array();

		// 未入力チェック：ジャンルID
		if (Validator::isNullOrEmpty($data['genre_id']))
		{
			$result[]['genre_id'] = Message::get('I002', array('ジャンルID'));
		}

		// 未入力チェック：タイトル
		if (Validator::isNullOrEmpty($data['title']))
		{
			$result[]['title'] = Message::get('I002', array('タイトル'));
		}

		foreach ($data['moving_url'] as $key => $val)
		{
			$no = (int)$key + 1;

			// 未入力チェック：動画URL
			if (Validator::isNullOrEmpty($val))
			{
				$result[]['moving_url' . $no] = Message::get('I002', array('動画URL' . $no));
				continue;
			}

			// 形式チェック：動画URL
			$video = null;
			preg_match('/(http:\/\/)(.*)(xvideos.com\/video)(.*)(\/)(.*)(\/)/', $val, $video);

			if (empty($video))
			{
				preg_match('/(http:\/\/)(.*)(xvideos.com\/video)(.*)(\/)/' , $val, $video);
				if (empty($video))
				{
					$result[]['moving_url' . $no] = Message::get('I005', array('動画URL' . $no));
					continue;
				}

				if (!isset($video[4]) || (int)$video[4] === 0 || !is_int((int)$video[4]))
				{
					$result[]['moving_url' . $no] = Message::get('I005', array('動画URL' . $no));
				}
			}
		}

		// 画像認証チェック
		if ($data['captcha_code'] !== $_SESSION['securimage_code_disp']['default'])
		{
			$result[]['captcha_code'] = Message::get('I006');
		}

		return $result;
	}

	protected function validateExec($data)
	{
		$result = array();

		// トークンチェック
		if(!$this->oneTimeToken->is_set($data['token']))
		{
			$result[] = Message::get('I001');
			return $result;
		}
		return $result;
	}

	protected function isValidateExec($data)
	{
		return $this->oneTimeToken->is_set($data['token']);
	}

}