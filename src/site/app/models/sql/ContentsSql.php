<?php

class ContentsSql extends AbstractSql
{
	public $virtualParamList = array();

	protected function virtualQuery($dbh)
	{
		$sql = "
UPDATE contents
SET
  view_count = :view_count
  , update_timestamp = NOW()
WHERE
  content_id = :content_id
  AND genre_id = :genre_id
";

		foreach ($this->virtualParamList as $key => $param)
		{
			$paramList = array(
				':view_count' => (int)$param['view_count'],
				':content_id' => (int)$param['content_id'],
				':genre_id' => (int)$param['genre_id'],
			);

			if (!SqlExec::queryForTrans($dbh, $sql, $paramList)) throw new PDOException();
		}
	}

}