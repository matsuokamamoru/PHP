<?php

class SearchModel extends ModelBase
{
	private $_itemCount = SEARCH_ITEM_COUNT;
	private $_pagerCount = SEARCH_PAGER_COUNT;

	public function find($words, $pageNo)
	{
		$result = array();

		if (parent::isViewSP())
		{
			$this->_itemCount = SP_SEARCH_ITEM_COUNT;
			$this->_pagerCount = SP_SEARCH_PAGER_COUNT;
		}

		$genreIdList = $this->_getGenre($words);

		$offset = ((int)$pageNo - 1) * $this->_itemCount;

		$sql = new SearchSql();

		// コンテンツ取得
		$result['contents'] = $sql->find($words, $genreIdList, $this->_itemCount, $offset);
		$result['contentsCount'] = $sql->count($words, $genreIdList);

		// ページング取得
		$pager = $this->_createPager($result['contentsCount'], $pageNo, $words);
		$result['pager'] = $pager->getLinkHtml();

		$result['nextPageNo'] = $pager->isNextPage !== false ? (int)$pageNo + 1 : null;

		return $result;
	}

	public function findByGenre($genreId, $pageNo)
	{
		$result = array();

		if (parent::isViewSP())
		{
			$this->_itemCount = SP_SEARCH_ITEM_COUNT;
			$this->_pagerCount = SP_SEARCH_PAGER_COUNT;
		}

		$offset = ((int)$pageNo - 1) * $this->_itemCount;

		$sql = new SearchSql();

		// コンテンツ取得
		$result['contents'] = $sql->findByGenre($genreId, $this->_itemCount, $offset);
		$result['contentsCount'] = $sql->countByGenre($genreId);

		// ページング取得
		$pager = $this->_createPager($result['contentsCount'], $pageNo, null, $genreId);
		$result['pager'] = $pager->getLinkHtml();

		$result['nextPageNo'] = $pager->isNextPage !== false ? (int)$pageNo + 1 : null;

		return $result;
	}

	private function _createPager($total, $pageNo, $words, $genreId = null)
	{
		// 引数にアイテムの個数、１画面あたりのアイテム表示数、ページングの表示数、現在ページを設定
		$pager = new Pager($total, $this->_itemCount, $this->_pagerCount, $pageNo);

		if ((int)$total === 0) return $pager;

		if (is_null($genreId))
		{
			// ページングのリンク先を設定（$test::REPLACE_TARGE_PAGE_NUMは対象のページ番号に置換される）
			$pager->setHrefTemp(URL_ROOT. 'search/index/'. '?q=' . implode(' ',  $words) . '&page_no=' . $pager::REPLACE_TARGE_PAGE_NUM);
		}
		else
		{
			// ページングのリンク先を設定（$test::REPLACE_TARGE_PAGE_NUMは対象のページ番号に置換される）
			$pager->setHrefTemp(URL_ROOT. 'search/genre/'. $genreId . '/' . $pager::REPLACE_TARGE_PAGE_NUM);
		}

		// 引数にスタイルを設定し、ページャーリンクを生成
		$pager->setPageTemp('<div id="paginate">'. $pager::REPLACE_TARGE_PAGE_ITEMS . '</div>');
		$pager->setPrevTemp('<a href="' . $pager::REPLACE_TARGE_PAGE_HREF . '">＜</a>');
		$pager->setNextTemp('<a href="' . $pager::REPLACE_TARGE_PAGE_HREF . '">＞</a>');
		$pager->setCurrentTemp('<strong>' . $pager::REPLACE_TARGE_PAGE_NUM . '</strong>');
		$pager->setNumTemp('<a href="' . $pager::REPLACE_TARGE_PAGE_HREF . '">'. $pager::REPLACE_TARGE_PAGE_NUM . '</a>');
		$pager->createPagerLink();

		return $pager;
	}

	private function _getGenre($words)
	{
		$result = array();

		foreach ($words as $word)
		{
			foreach (WrapSpyc::getValueArray('genre') as $key => $genre)
			{
				if (strstr($genre, $word))
				{
					$result[] = $key;
					continue;
				}

				$_word = mb_convert_kana($word, 'KVC');
				if (strstr($genre, $_word))
				{
					$result[] = $key;
					continue;
				}

			}
		}

		return $result;
	}

}