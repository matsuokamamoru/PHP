<?php

class TagModel extends ModelBase
{

	public function insert($data)
	{
		$sql = new TagSql();

		// Parameter set
		$param = $this->_convert($data);
		$sql->Regist($params);

		return;
	}

	public function delete($tagId)
	{
		$sql = new TagSql();
		$sql->delete($tagId);

		return;
	}

	public function validateAdd(array $data)
	{
		$result = $this->_validate($data);

		// 未入力チェック：Word
		if (Validator::isNullOrEmpty($data['word']))
		{
			$result[]['word'] = Message::get('I002', array('ワード'));
		}

		if (!Validator::isMaxLength(20, $data['word']))
		{
			$result[]['word'] = Message::get('I003', array('ワード', 20));
		}

		return $result;
	}

	public function validateDelete(array $data)
	{
		return $this->_validate($data);
	}

	public function _validate($data)
	{

		$result = array();

		// 未入力チェック：コンテンツID
		if (Validator::isNullOrEmpty($data['content_id']))
		{
			$result[]['content_id'] = Message::get('I002', array('コンテンツID'));
		}

		// 未入力チェック：タグID
		if (Validator::isNullOrEmpty($data['tag_id']))
		{
			$result[]['tag_id'] = Message::get('I002', array('タグID'));
		}

		return $result;
	}
}
