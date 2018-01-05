<?php

class TagsSql extends AbstractSql
{
	public $virtualParamList = array();

	public function find($contentId)
	{
		$sql = "
SELECT
  tag_id
  , content_id
  , word
FROM
  tags
WHERE
  content_id = :content_id
ORDER BY
  tag_id ASC
";

		$paramList = array(
			':content_id' => (int)$contentId,
		);

		return SqlSelect::fetchAll($sql, $paramList);
	}

	protected function virtualQuery($dbh)
	{
		// タグ削除
		$deleteSql = "
DELETE
FROM
  tags
WHERE
  content_id = :content_id
";

		$deleteParamList = array(
			':content_id' => (int)$this->virtualParamList['content_id'],
		);

		if (!SqlExec::queryForTrans($dbh, $deleteSql, $deleteParamList)) throw new PDOException();


		if (count($this->virtualParamList['words']) === 0) return;


		// タグ登録
		$insertSql = "
INSERT
INTO tags(content_id, word, create_datetime)
VALUES (:content_id, :word, NOW())
";

		foreach ($this->virtualParamList['words'] as $key => $word)
		{
			$insertParamList = array(
				':content_id' => (int)$this->virtualParamList['content_id'],
				':word' => $word,
			);

			if (!SqlExec::queryForTrans($dbh, $insertSql, $insertParamList)) throw new PDOException();
		}

	}

}
