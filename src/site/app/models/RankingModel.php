<?php

class RankingModel extends ModelBase
{
	private $_itemCount = RANKING_ITEM_COUNT;
	private $_pagerCount = RANKING_PAGER_COUNT;

	public function find($pageNo)
	{
		if (parent::isViewSP())
		{
			$this->_itemCount = SP_RANKING_ITEM_COUNT;
			$this->_pagerCount = SP_RANKING_PAGER_COUNT;
		}

		$result = array();

		// コンテンツ取得
		$sql = new RankingSql();

		$result['contentsCount'] = $sql->findCache(array(), 'virtualCountByDaily');

		$_data = array(
			'limit' => $this->_itemCount,
			'offset' => ((int)$pageNo - 1) * $this->_itemCount,
		);
		$result['contents'] = $sql->findCache($_data, 'virtualFindByDaily');

		// ページング取得
		$pager = $this->_createPager($result['contentsCount'], $pageNo);
		$result['pager'] = $pager->getLinkHtml();

		$result['nextPageNo'] = $pager->isNextPage !== false ? (int)$pageNo + 1 : null;

		return $result;
	}

	private function _createPager($total, $pageNo)
	{
		// 引数にアイテムの個数、１画面あたりのアイテム表示数、ページングの表示数、現在ページを設定
		$pager = new Pager($total, $this->_itemCount, $this->_pagerCount, $pageNo);

		if ((int)$total === 0) return $pager;

		// ページングのリンク先を設定（$test::REPLACE_TARGE_PAGE_NUMは対象のページ番号に置換される）
		$pager->setHrefTemp(URL_ROOT. 'ranking/index/'. $pager::REPLACE_TARGE_PAGE_NUM);

		// 引数にスタイルを設定し、ページャーリンクを生成
		$pager->setPageTemp('<div id="paginate">'. $pager::REPLACE_TARGE_PAGE_ITEMS . '</div>');
		$pager->setPrevTemp('<a href="' . $pager::REPLACE_TARGE_PAGE_HREF . '">＜</a>');
		$pager->setNextTemp('<a href="' . $pager::REPLACE_TARGE_PAGE_HREF . '">＞</a>');
		$pager->setCurrentTemp('<strong>' . $pager::REPLACE_TARGE_PAGE_NUM . '</strong>');
		$pager->setNumTemp('<a href="' . $pager::REPLACE_TARGE_PAGE_HREF . '">'. $pager::REPLACE_TARGE_PAGE_NUM . '</a>');
		$pager->createPagerLink();

		return $pager;
	}

	public function insert()
	{
		$sql = new RankingSql();
		return $sql->queryForTrans();
	}

}