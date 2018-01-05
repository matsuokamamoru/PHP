<?php

class HotWordsSql
{
	public function find($limit, $offset)
	{
		$sql = "
SELECT
  word
  , view_count
FROM
  hot_words
ORDER BY
  view_count DESC
LIMIT
  :offset, :limit
";

		$paramList = array(
			':offset' => (int)$offset,
			':limit' => (int)$limit,
		);

		return SqlSelect::fetchAll($sql, $paramList);
	}

	public function insert($word)
	{
		$sql = "
INSERT
INTO hot_words(
  word
  , view_count
  , create_datetime
  , update_timestamp
)
VALUES (:word, 1, NOW(), NOW())
  ON DUPLICATE KEY UPDATE view_count = view_count + 1
  , update_timestamp = NOW()
";

		$paramList = array(
			':word' => $word,
		);

		// トランザクションなし
		return SqlExec::queryForTrans(DBConnection::getDbh(), $sql, $paramList);
	}

}