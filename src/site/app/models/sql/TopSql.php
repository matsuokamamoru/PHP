<?php

class TopSql
{
	public function find($limit, $offset)
	{
		$sql = "
SELECT
  T1.content_id
  , T1.genre_id
  , T1.title
  , T1.description
  , T1.view_count
  , T2.thumbnail_img_url
  , T2.play_time
FROM
  contents T1
  INNER JOIN media T2
    ON T1.content_id = T2.content_id
    AND T2.media_id = 1
WHERE
  T1.delete_flg = 0
ORDER BY
  T1.create_datetime DESC
  , T1.content_id DESC
LIMIT
  :offset, :limit
";

		$paramList = array(
			':offset' => (int)$offset,
			':limit' => (int)$limit,
		);

		return SqlSelect::fetchAll($sql, $paramList);
	}

	public function count()
	{
		$sql = "
SELECT
  COUNT(T1.content_id) data_count
FROM
  contents T1
  INNER JOIN media T2
    ON T1.content_id = T2.content_id
    AND T2.media_id = 1
WHERE
  T1.delete_flg = 0
";

		$data = SqlSelect::fetchAll($sql);

		return $data[0]['data_count'];
	}

}