<?php

class NewVideosModel extends ModelBase
{
	public function convert($links)
	{
		$result = array();

		foreach($links as $key => $link)
		{
			$imgPath = null;
			preg_match('/(http:\/\/)(.*)(xvideos.com\/videos\/thumbs.*)(\.)(.*)(\.)(jpg|png)/' , $link['linkcode'], $imgPath);

			$thumbsImgUrl = $imgPath[1] . $imgPath[2] . $imgPath[3] . ".$imgPath[5]." . $imgPath[7];

			$result[] = array(
				'title' => '',
				'thumbnail_img_url' => $thumbsImgUrl,
				'media' => $link['url_rebuild'],
			);
		}

		return $result;
	}

	public function insert($data)
	{
		$result = false;

		$sql = new NewVideosSql();

		// コネクション取得
		$dbh = DBConnection::getDbh();

		try
		{
			// トランザクション開始
			$dbh->beginTransaction();

			$sql->truncate($dbh);

			foreach($data as $key => $item)
			{
				if (!$sql->insert($dbh, $item))
				{
					throw new PDOException();
				}
			}

			// トランザクションコミット
			$dbh->commit();

			$stmt = null;
			$dbh = null;

			$result = true;
		}
		catch (PDOException $ex)
		{
			// トランザクションロールバック
			$dbh->rollBack();

			$stmt = null;
			$dbh = null;

			// 例外をベースになげる
			throw $ex;
		}

		return $result;
	}

}