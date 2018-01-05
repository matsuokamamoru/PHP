<?php

class NewVideosSql
{
	public function find($limit, $offset)
	{
		$sql = "
SELECT
  content_id
  , title
  , thumbnail_img_url
FROM
  new_videos
ORDER BY
  content_id ASC
LIMIT
  :offset, :limit
";

		$paramList = array(
			':offset' => (int)$offset,
			':limit' => (int)$limit,
		);

		return SqlSelect::fetchAll($sql, $paramList);
	}

	public function findById($id)
	{
		$sql = "
SELECT
  content_id
  , 'XVIDEOSの新着' title
  , thumbnail_img_url
  , media
  , 'XVIDEOSの新着動画 (1時間更新)' description
  , DATE_FORMAT(create_datetime, '%Y/%m/%d') create_date
FROM
  new_videos
WHERE
  content_id = :content_id
";

		$paramList = array(
			':content_id' => (int)$id,
		);

		return SqlSelect::fetchAll($sql, $paramList);
	}

	public function truncate($dbh)
	{
		$sql = "TRUNCATE TABLE new_videos";

		return SqlExec::queryForTrans($dbh, $sql);
	}

	public function insert($dbh, $data)
	{
		$sql = "
INSERT
INTO new_videos(
  title
  , thumbnail_img_url
  , media
  , create_datetime
)
VALUES (
  :title
  , :thumbnail_img_url
  , :media
  , now()
)
";

		return SqlExec::queryForTrans($dbh, $sql, $data);
	}

}