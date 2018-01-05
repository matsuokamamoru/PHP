<?php
class CreateSql extends AbstractSql
{
	public $virtualParamList = array();
	private $_contentId = null;

	public function getContentId()
	{
		return $this->_contentId;
	}

	protected function virtualQuery($dbh)
	{
		$insertId = $this->_insertContents($dbh);
		$this->_insertMedia($dbh, $insertId);
		$this->_contentId = $insertId;
	}

	private function _insertContents($dbh)
	{
		$sql = "
INSERT
INTO contents(
  genre_id
  , title
  , description
  , create_date
  , create_datetime
  , delete_flg
)
values (
  :genre_id
  , :title
  , :description
  , DATE_FORMAT(NOW(), '%Y/%m/%d')
  , NOW()
  , 0
)
";

		$paramList = array(
			':genre_id'    => $this->virtualParamList['contents']['genre_id'],
			':title'       => $this->virtualParamList['contents']['title'],
			':description' => $this->virtualParamList['contents']['description']
		);
		if (!SqlExec::queryForTrans($dbh, $sql, $paramList)) throw new PDOException();
		return $dbh->lastInsertId();
	}

	private function _insertMedia($dbh, $insertId)
	{
		$sql = "
INSERT
INTO media(
  content_id
  , media_id
  , media
  , media_type
  , create_datetime
)
values (:content_id, :media_id, :media, 0, NOW())
";

		foreach($this->virtualParamList['media'] as $val)
		{
			$paramList = array(
				':content_id' => (int)$insertId,
				':media_id'   => $val['media_id'],
				':media'      => $val['media']
			);

			if (!SqlExec::queryForTrans($dbh, $sql, $paramList)) throw new PDOException();
		}
	}

}