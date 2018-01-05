<?php

class SearchSql
{
	private static $select = "
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
";

	private static $countSelect = "
SELECT
  COUNT(T1.content_id) data_count
FROM
  contents T1
  INNER JOIN media T2
    ON T1.content_id = T2.content_id
    AND T2.media_id = 1
";

	/**
	 * 検索
	 *
	 * @param array $words
	 * @param array $genreIdList
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function find($words, $genreIdList, $limit, $offset)
	{
		$sql = self::$select .= "
WHERE
  T1.delete_flg = 0
";

		$paramList = array(
			':offset' => (int)$offset,
			':limit' => (int)$limit,
		);

		$sql .= $this->_addParam($words, $genreIdList, $paramList);

		$sql .= "
ORDER BY
  T1.create_datetime DESC
  , T1.content_id DESC
LIMIT
  :offset, :limit
";

		return SqlSelect::fetchAll($sql, $paramList);
	}

	/**
	 * 件数取得
	 *
	 * @param array $words
	 * @param array $genreIdList
	 * @return int
	 */
	public function count($words, $genreIdList)
	{
		$sql = self::$countSelect .= "
WHERE
  T1.delete_flg = 0
";

		$paramList = array();
		$sql .= $this->_addParam($words, $genreIdList, $paramList);

		$data = SqlSelect::fetchAll($sql, $paramList);

		return $data[0]['data_count'];
	}

	private function _addParam($words, $genreIdList, &$paramList)
	{
		$sql = '';

		if (!empty($words) && $words[0] !== '')
		{
			$sql .= "
  AND EXISTS (
    SELECT
      content_id
    FROM
      tags
    WHERE
      content_id = T1.content_id
      AND (
";
			$sqlWord = '';
			foreach ($words as $key => $word)
			{
				$sqlWord .= "word collate utf8_unicode_ci LIKE :word_" . $key . " OR ";
				$paramList[':word_' . $key] = "%" . $word . "%";
			}

			$sql .= substr($sqlWord, 0, -4) . "))";

			// タイトルに対しても検索をかける
			$sql .= "
  OR (
";
			$sqlTitle = '';
			foreach ($words as $key => $word)
			{
				$sqlTitle .= "T1.title collate utf8_unicode_ci LIKE :title_" . $key . " OR ";
				$paramList[':title_' . $key] = "%" . $word . "%";
			}

			$sql .= substr($sqlTitle, 0, -4) . ")";
		}

		if (!empty($genreIdList))
		{
			if (!empty($words) && $words[0] !== '')
			{
				$sql .= "
  OR T1.genre_id IN (
";
			}
			else
			{
				$sql .= "
  AND T1.genre_id IN (
";
			}

			$sqlGenre = '';
			foreach ($genreIdList as $key => $genreId)
			{
				$sqlGenre .= ":genre_id_" . $key . ",";
				$paramList[':genre_id_' . $key] = (int)$genreId;
			}

			$sql .= substr($sqlGenre, 0, -1) . ")";
		}

		return $sql;
	}

	/**
	 * 検索：ジャンル指定
	 *
	 * @param int $genreId
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function findByGenre($genreId, $limit, $offset)
	{
		$sql = self::$select .= "
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

	/**
	 * 件数取得：ジャンル指定
	 *
	 * @param int $genreId
	 * @return int
	 */
	public function countByGenre($genreId)
	{
		$sql = self::$countSelect .= "
WHERE
  T1.delete_flg = 0
  AND T1.genre_id = :genre_id
";

		$paramList = array(
			':genre_id' => (int)$genreId,
		);

		$data = SqlSelect::fetchAll($sql, $paramList);

		return $data[0]['data_count'];
	}

}