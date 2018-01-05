<?php

class TopModel extends ModelBase
{
	private $_itemCount = TOP_ITEM_COUNT;
	private $_pagerCount = TOP_PAGER_COUNT;

	public function find($pageNo)
	{
		if (parent::isViewSP())
		{
			$this->_itemCount = SP_TOP_ITEM_COUNT;
			$this->_pagerCount = SP_TOP_PAGER_COUNT;
		}

		$result = array();

		$offset = ((int)$pageNo - 1) * $this->_itemCount;

		$sql = new TopSql();

		// コンテンツ取得
		$result['contents'] = $sql->find($this->_itemCount, $offset);
		$result['contentsCount'] = $sql->count();

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
		$pager->setHrefTemp(URL_ROOT. 'top/index/'. $pager::REPLACE_TARGE_PAGE_NUM);

		// 引数にスタイルを設定し、ページャーリンクを生成
		$pager->setPageTemp('<div id="paginate">'. $pager::REPLACE_TARGE_PAGE_ITEMS . '</div>');
		$pager->setPrevTemp('<a href="' . $pager::REPLACE_TARGE_PAGE_HREF . '">＜</a>');
		$pager->setNextTemp('<a href="' . $pager::REPLACE_TARGE_PAGE_HREF . '">＞</a>');
		$pager->setCurrentTemp('<strong>' . $pager::REPLACE_TARGE_PAGE_NUM . '</strong>');
		$pager->setNumTemp('<a href="' . $pager::REPLACE_TARGE_PAGE_HREF . '">'. $pager::REPLACE_TARGE_PAGE_NUM . '</a>');
		$pager->createPagerLink();

		return $pager;
	}

}