<?php

class ThumbnailModel extends ModelBase
{
	public function findByImgUrlInNull()
	{
		return (new MediaSql())->findByImgUrlInNull();
	}

	public function convert($data)
	{
		$result = array();

		foreach ($data as $key => $item)
		{
			$duration = str_replace(array(' ', '　'), array('', ''), $item['duration']);
			$item['play_time'] = $this->_convertPlayTime($duration);

			$result[] = $item;
		}

		return $result;
	}

	public function update($data)
	{
		$sql = new MediaSql();
		$sql->virtualParamList = $data;
		return $sql->queryForTrans();
	}

	private function _convertPlayTime($value)
	{
		$matches = null;

		$time = '00:00';

		// h min sec
		if (preg_match('/-([0-9]*)h([0-9]*)min([0-9]*)sec/' , $value, $matches))
		{
			$time = $matches[1] . ':' . sprintf('%02d', $matches[2]) . ':' . sprintf('%02d', $matches[3]);
		}
		// h min
		else if (preg_match('/-([0-9]*)h([0-9]*)min/' , $value, $matches))
		{
			$time = $matches[1] . ':' . sprintf('%02d', $matches[2]) . ':00';
		}
		// h sec
		else if (preg_match('/-([0-9]*)h([0-9]*)sec/' , $value, $matches))
		{
			$time = $matches[1] . ':00:' . sprintf('%02d', $matches[2]);
		}
		// min sec
		else if (preg_match('/-([0-9]*)min([0-9]*)sec/' , $value, $matches))
		{
			$time = sprintf('%02d', $matches[1]) . ':' . sprintf('%02d', $matches[2]);
		}
		// h
		else if (preg_match('/-([0-9]*)h/' , $value, $matches))
		{
			$time = $matches[1] . ':00:00';
		}
		// min
		else if (preg_match('/-([0-9]*)min/' , $value, $matches))
		{
			$time = sprintf('%02d', $matches[1]) . ':00';
		}
		// sec
		else if (preg_match('/-([0-9]*)sec/' , $value, $matches))
		{
			$time = '00:' . sprintf('%02d', $matches[1]);
		}

		return $time;
	}

}