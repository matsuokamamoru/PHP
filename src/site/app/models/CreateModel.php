<?php

class CreateModel extends AbstractCreateModel
{
	const SESSION_KEY = 'create_data';

	private $_default = array(
		'genre_id'   => 0,
		'title'      => '',
		'detail'     => '',
		'moving_url' => array(),
		'error'      => array()
	);

	public function __construct()
	{
		parent::__construct(self::SESSION_KEY);
	}

	public function getData($data)
	{
		$result = $this->_default;
		if (!is_null($data))
		{
			$result = array_merge($result, $data);
		}
		return $result;
	}

	public function convertMovingUrl($data)
	{
		$result = $data;

		foreach ($result['moving_url'] as $key => $url)
		{
			// flashserviceのURLを生成
			$video = null;
			preg_match('/(http:\/\/)(.*)(xvideos.com\/video)(.*)(\/)(.*)(\/)/', $url, $video);

			if (empty($video))
			{
				preg_match('/(http:\/\/)(.*)(xvideos.com\/video)(.*)(\/)/' , $url, $video);
			}

			$result['_moving_url'][] = 'http://flashservice.xvideos.com/embedframe/' . $video[4];
		}

		return $result;
	}

	public function insert($data)
	{
		$sql = new CreateSql();
		// Parameter set
		$param = $this->_convert($data);
		$sql->virtualParamList = $param;
		// 登録処理
		$sql->queryForTrans();
		$param['content_id'] = $sql->getContentId();
		return $param;
	}

	public function writeContents(array $data)
	{
		try
		{
			if (!$data['content_id'])
				throw new Exception('コンテンツIDが存在しません');

			$filePath = DIR_TMP . '/media/' . (new DateTime())->format('Ymd') . '_' . $data['content_id'];
			File::put($filePath, $this->_convertFileContents($data));
		}
		catch (Exception $e)
		{
			$msg = print_r($data, true);
			$path  = (new DateTime())->format('Ymd').'_cron_error.log';
			Logger::setLogName(DIR_LOG.'/'. $path);
			Logger::write($msg);
		}
		return ;
	}

	public function getToken()
	{
		return $this->oneTimeToken->create();
	}

	public function validate($data)
	{
		return parent::validate($data);
	}

	public function validateExec($data)
	{
		return parent::validateExec($data);
	}

	public function isValidateExec($data)
	{
		return parent::isValidateExec($data);
	}

	private function _convert(array $data)
	{
		$result['contents'] = array(
			'genre_id'    => $data['genre_id'],
			'title'       => $data['title'],
			'description' => $data['detail']
		);

		$madiaNum = 1;
		$result['media'] = array();
		foreach ($data['moving_url'] as $key => $val)
		{
			$result['media'][$key]['media']    = $val;
			$result['media'][$key]['media_id'] = $madiaNum;
			$madiaNum++;
		}
		return $result;
	}

	private function _convertFileContents(array $data)
	{
		$ret = array();
		foreach ($data['media'] as $key => $val)
		{
			$ret[$key] = array(
				'content_id'  => $data['content_id'],
				'media_id'    => $val['media_id'],
				'media'       => $val['media']
			);
		}
		return serialize($ret);
	}
}