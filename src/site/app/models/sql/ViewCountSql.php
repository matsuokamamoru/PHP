<?php

class ViewCountSql
{
	public function findWithin30Minutes()
	{
		$sql = "
SELECT
  content_id
  , genre_id
  , view_count
FROM
  view_count
WHERE
  DATE_ADD(update_timestamp, INTERVAL 30 MINUTE) > NOW()
ORDER BY
  content_id
  , genre_id
";

		return SqlSelect::fetchAll($sql);
	}

	public function insert($contentId, $genreId)
	{
		$sql = "
INSERT
INTO view_count(
  content_id
  , genre_id
  , view_count
  , create_datetime
  , update_timestamp
)
VALUES (:content_id, :genre_id, 1, NOW(), NOW())
  ON DUPLICATE KEY UPDATE view_count = view_count + 1
  , update_timestamp = NOW()
";

		$paramList = array(
			':content_id' => (int)$contentId,
			':genre_id' => (int)$genreId,
		);

		// トランザクションなし
		return SqlExec::queryForTrans(DBConnection::getDbh(), $sql, $paramList);
	}

}