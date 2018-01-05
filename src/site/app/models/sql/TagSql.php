<?php

#alter table tags change tag_id tag_id int UNIQUE not null;

class TagSql extends AbstractSql
{
	public function Regist(array $params)
	{
$sql = "
INSERT
INTO tags(
   content_id
  ,tag_id
  ,word
  ,create_datetime
) VALUES (
   :content_id
  ,:tag_id
  ,:word
  ,NOW()
) ON DUPLICATE KEY UPDATE
  word = :word
";
		$paramList = array(
				':content_id' => $params['content_id'],
				':tag_id'      => $params['tag_id'],
				':word'       => $params['word'],
		);
		// トランザクションなし
		return SqlExec::queryForTrans(DBConnection::getDbh(), $sql, $paramList);
	}

	public function delete(array $params)
	{
$sql = "
 DELETE
 FROM tags
 WHERE
     tag_id = :tag_id
 AND content_id = :content_id
";
		$paramList = array(
			':content_id' => $params['content_id'],
			':tag_id'     => $params['tag_id'],
		);
		// トランザクションなし
		return SqlExec::queryForTrans(DBConnection::getDbh(), $sql, $paramList);
	}
}
