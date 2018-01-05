<?php

class RankingSql extends AbstractSql
{
	public $virtualParamList = array();

	public function __construct()
	{
		parent::loadCacheSetting('ranking');
	}

	protected function virtualQuery($dbh)
	{
		// デイリーランキングデータ作成
		if (!SqlExec::queryForTrans($dbh, "TRUNCATE TABLE ranking_daily")) throw new PDOException();

		if (!SqlExec::queryForTrans($dbh, "INSERT INTO ranking_daily SELECT * FROM view_count_daily")) throw new PDOException();

		// ※全てのランキングデータの作成が完了したら閲覧集計（日）テーブルのデータを削除する。
		if (!SqlExec::queryForTrans($dbh, "TRUNCATE TABLE view_count_daily")) throw new PDOException();
	}

	protected function virtualCountByDaily($data)
	{
		$sql = "
SELECT
  COUNT(T1.content_id) data_count
FROM
  ranking_daily T1
  INNER JOIN contents T2
    ON T1.content_id = T2.content_id
  INNER JOIN media T3
    ON T1.content_id = T3.content_id
    AND T3.media_id = 1
WHERE
  T2.delete_flg = 0
";

		$data = SqlSelect::fetchAll($sql);

		return $data[0]['data_count'];
	}

	protected function virtualFindByDaily($data)
	{
		$sql = "
SELECT
  @rownum := @rownum + 1 rownum
  , T1.content_id
  , T1.genre_id
  , T2.title
  , T2.description
  , T3.thumbnail_img_url
  , T3.play_time
FROM
  ( SELECT @rownum := :offset ) T0,
  ranking_daily T1
  INNER JOIN contents T2
    ON T1.content_id = T2.content_id
  INNER JOIN media T3
    ON T1.content_id = T3.content_id
    AND T3.media_id = 1
WHERE
  T2.delete_flg = 0
ORDER BY
  T1.view_count DESC
  , T1.content_id DESC
LIMIT
  :offset, :limit
";

		$paramList = array(
			':offset' => (int)$data['offset'],
			':limit' => (int)$data['limit'],
		);

		return SqlSelect::fetchAll($sql, $paramList);
	}

}