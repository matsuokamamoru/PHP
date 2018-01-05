<?php

class SidebarModel extends ModelBase
{
	public function findNewVideos()
	{
		return (new NewVideosSql())->find(25, 0);
	}

	public function findRanking()
	{
		$sql = new RankingSql();

		$_data = array(
			'limit' => 5,
			'offset' => 0,
		);

		return $sql->findCache($_data, 'virtualFindByDaily');
	}

	public function findHotWords()
	{
		return (new HotWordsSql())->find(25, 0);
	}

}