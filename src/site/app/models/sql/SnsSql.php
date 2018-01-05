<?php

class SnsSql
{
	public function findWithinRand($limit, $offset)
	{
		$sql = "
SELECT
  content_id
  , genre_id
  , title
FROM
  contents
WHERE
  delete_flg = 0
ORDER BY
  RAND()
LIMIT
  :offset, :limit
";

		$paramList = array(
				':offset' => (int)$offset,
				':limit' => (int)$limit,
		);

		return SqlSelect::fetchAll($sql, $paramList);
	}

	public function findWithin1Hours($limit, $offset)
	{
		$sql = "
SELECT
  content_id
  , genre_id
  , title
FROM
  contents
WHERE
  delete_flg = 0
  AND DATE_ADD(create_datetime, INTERVAL 1 HOUR) > NOW()
ORDER BY
  RAND()
LIMIT
  :offset, :limit
";

		$paramList = array(
			':offset' => (int)$offset,
			':limit' => (int)$limit,
		);

		return SqlSelect::fetchAll($sql, $paramList);
	}

}