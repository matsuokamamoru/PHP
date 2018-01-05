<?php

class DetailSql
{
	public function find($contentId)
	{
		$sql = "
SELECT
  T1.content_id
  , T1.genre_id
  , T1.title
  , T1.description
  , T1.view_count
  , T1.create_date
  , T2.media
  , T2.thumbnail_img_url
  , T2.play_time
FROM
  contents T1
  INNER JOIN media T2
    ON T1.content_id = T2.content_id
WHERE
  T1.delete_flg = 0
  AND T1.content_id = :content_id
";

		$paramList = array(
			':content_id' => (int)$contentId,
		);

		return SqlSelect::fetchAll($sql, $paramList);
	}

	public function findRelatedContents($genreId, $limit, $offset)
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
  AND T1.genre_id = :genre_id
ORDER BY
  T1.create_datetime DESC
  , T1.content_id DESC
LIMIT
  :offset, :limit
";

		$paramList = array(
			':genre_id' => (int)$genreId,
			':offset' => (int)$offset,
			':limit' => (int)$limit,
		);

		return SqlSelect::fetchAll($sql, $paramList);
	}

}