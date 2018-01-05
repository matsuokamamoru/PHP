<?php

class ViewCountModel extends ModelBase
{
	public function get()
	{
		return (new ViewCountSql())->findWithin30Minutes();
	}

	public function update($data)
	{
		$sql = new ContentsSql();
		$sql->virtualParamList = $data;
		return $sql->queryForTrans();
	}

}