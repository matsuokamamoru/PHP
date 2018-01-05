<?php

class CountModel extends ModelBase
{
	public function insertViewCount($contentId, $genreId)
	{
		return (new ViewCountSql())->insert($contentId, $genreId);
	}

	public function insertViewCountDaily($contentId, $genreId)
	{
		return (new ViewCountDailySql())->insert($contentId, $genreId);
	}

	public function insertHotWords($words)
	{
		$sql = new HotWordsSql();

		foreach ($words as $key => $word)
		{
			if (empty($word)) continue;

			if (!$sql->insert($word)) return false;
		}

		return true;
	}

}