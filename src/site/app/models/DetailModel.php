<?php

class DetailModel extends ModelBase
{
	public function find($contentId)
	{
		$result = array();

		$sql = new DetailSql();

		// コンテンツ取得
		$result['contents'] = $this->_convert($sql->find($contentId));

		$relatedLimit = parent::isViewSP() ? 5 : 8;
		$result['relatedContents'] = $sql->findRelatedContents($result['contents'][0]['genre_id'], $relatedLimit, 0);

		$result['tags'] = (new TagsSql())->find($contentId);

		return $result;
	}

	public function findForNewVideos($contentId)
	{
		$result = array();

		// コンテンツ取得
		$result['contents'] = $this->_convert((new NewVideosSql())->findById($contentId));

		$result['relatedContents'] = array();

		$result['tags'] = array();

		return $result;
	}

	private function _convert($contents)
	{
		$result = array();

		if (count($contents) === 0) throw new NotFoundException();

		foreach ($contents as $key => $content)
		{
			// flashserviceのURLを生成
			$video = null;
			preg_match('/(http:\/\/)(.*)(xvideos.com\/video)(.*)(\/)(.*)(\/)/', $content['media'], $video);

			if (empty($video))
			{
				preg_match('/(http:\/\/)(.*)(xvideos.com\/video)(.*)(\/)/' , $content['media'], $video);
				if (empty($video)) throw new NotFoundException();
			}

			if (!isset($video[4]) || (int)$video[4] === 0 || !is_int((int)$video[4])) throw new NotFoundException();

			$content['video_id'] = $video[4];
			$content['video_url'] = 'http://flashservice.xvideos.com/embedframe/' . $video[4];

			// サムネイル画像のURLを生成
			$thumbs = null;
			preg_match('/(http:\/\/)(.*)(xvideos.com\/videos\/thumbs.*)(\.)(.*)(\.)(jpg|png)/', $content['thumbnail_img_url'], $thumbs);

			$no = 1;
			for ($i = 3; $i <= 30; $i+=3)
			{
				$thumbsUrl = null;
				if (!empty($content['thumbnail_img_url']))
				{
					$thumbsUrl = $thumbs[1] . $thumbs[2] . $thumbs[3] . ".$no." . $thumbs[7];
				}

				$content['thumbnail_img_url' . $no] = $thumbsUrl;

				$no += 1;
			}

			$result[] = $content;
		}

		return $result;
	}

}