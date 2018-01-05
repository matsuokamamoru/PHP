<?php

class MediaSql extends AbstractSql
{
	public $virtualParamList = array();

	public function find($contentId)
	{
		$sql = "
SELECT
  content_id
  , media_id
  , media
FROM
  media
WHERE
  content_id = :content_id
ORDER BY
  media_id ASC
";

		$paramList = array(
			':content_id' => (int)$contentId,
		);

		return SqlSelect::fetchAll($sql, $paramList);
	}

	public function findByImgUrlInNull()
	{
		$sql = "
SELECT
  content_id
  , media_id
  , media
  , thumbnail_img_url
FROM
  media
WHERE
  thumbnail_img_url IS NULL
  AND DATE_ADD(create_datetime, INTERVAL 3 DAY) > NOW()
ORDER BY
  content_id ASC
  , media_id ASC
";

		return SqlSelect::fetchAll($sql);
	}

	protected function virtualQuery($dbh)
	{
		$sql = "
UPDATE media
SET
  thumbnail_img_url = :thumbnail_img_url
  , play_time = :play_time
  , update_timestamp = NOW()
WHERE
  content_id = :content_id
  AND media_id = :media_id
";

		foreach ($this->virtualParamList as $key => $param)
		{
			$paramList = array(
				':thumbnail_img_url' => empty($param['thumbnail_img_url']) ? null : $param['thumbnail_img_url'],
				':play_time' => $param['play_time'],
				':content_id' => (int)$param['content_id'],
				':media_id' => (int)$param['media_id'],
			);

			if (!SqlExec::queryForTrans($dbh, $sql, $paramList)) throw new PDOException();
		}
	}

}