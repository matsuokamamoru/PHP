<?php

class TagsModel extends ModelBase
{
	public function validate(array $data)
	{
		$result = array();

		// トークンチェック
		if(!$this->oneTimeToken->isSetLimited($data['token']))
		{
			$result[] = Message::get('I001');
		}

		// 未入力チェック：コンテンツID
		if (Validator::isNullOrEmpty($data['content_id']))
		{
			$result[] = Message::get('I002', array('コンテンツID'));
		}

		// 長さチェック：ワード
		if (0 < count($data['words']))
		{
			foreach ($data['words'] as $key => $word)
			{
				if (!Validator::isMaxLength(20, $word))
				{
					$result[] = Message::get('I003', array('ワード' . $key + 1, 20));
				}
			}
		}

		return $result;
	}

	public function insert($data)
	{
		$sql = new TagsSql();
		$sql->virtualParamList = $data;
		return $sql->queryForTrans();
	}

}
