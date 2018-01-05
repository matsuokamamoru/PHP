<?php

class Pager
{
	// 文字列置換用定数
	const REPLACE_TARGE_ATTRIBUTE  = '%_ATTRIBUTE_%';
	const REPLACE_TARGE_PAGE_NUM   = '%_PAGE_NUM_%';
	const REPLACE_TARGE_PAGE_ITEMS = '%_PAGE_ITEMS_%';
	const REPLACE_TARGE_PAGE_HREF  = '%_PAGE_HREF_%';

	public $isNextPage = false;

	private $pagerItem;
	private $linkHtml;
	private $pageTemp;
	private $numTemp;
	private $currentTemp;
	private $prevTemp;
	private $nextTemp;
	private $hrefTemp;
	private $beforNumTemp;
	private $afterNumTemp;

	public function getPagerItem()
	{
		return $this->pagerItem;
	}

	public function setPagerItem($pagerItem)
	{
		$this->pagerItem = $pagerItem;
	}

	/**
	 * ページングHTMLの取得
	 * @access public
	 * @return $linkHtml
	 */
	public function getLinkHtml()
	{
		return $this->linkHtml;
	}

	/**
	 * ページングHTMLの設定
	 * @access private
	 * @param $linkHtml
	 */
	private function setLinkHtml($linkHtml)
	{
		$this->linkHtml = $linkHtml;
	}

	/**
	 * ページングのテンプレート設定
	 * ※REPLACE_TARGE_ATTRIBUTE、REPLACE_TARGE_PAGE_ITEMSの文字列を内部で置換します。
	 * @access public
	 * @param $pageTemp
	 */
	public function setPageTemp($pageTemp)
	{
		$this->pageTemp = $pageTemp;
	}

	/**
	 * ページング番号直前のテンプレート設定
	 * @access public
	 * @param $beforNumTemp
	 */
	public function setBeforNumTemp($beforNumTemp)
	{
		$this->beforNumTemp = $beforNumTemp;
	}

	/**
	 * ページング番号直前のテンプレート設定
	 * @access public
	 * @param $beforNumTemp
	 */
	public function setAfterNumTemp($afterNumTemp)
	{
		$this->afterNumTemp = $afterNumTemp;
	}

	/**
	 * ページング番号のテンプレート設定
	 * ※REPLACE_TARGE_PAGE_NUM、REPLACE_TARGE_PAGE_NUMの文字列を内部で置換します。
	 * @access public
	 * @param $currentTemp
	 */
	public function setNumTemp($numTemp)
	{
		$this->numTemp = $numTemp;
	}

	/**
	 * 現在のページング番号のテンプレート設定
	 *
	 * @access public
	 * @param $currentTemp
	 */
	public function setCurrentTemp($currentTemp)
	{
		$this->currentTemp = $currentTemp;
	}

	/**
	 * PREVリンクのテンプレート設定
	 * ※REPLACE_TARGE_PAGE_NUM、REPLACE_TARGE_PAGE_NUMの文字列を内部で置換します。
	 *
	 * @access public
	 * @param $prevTemp
	 */
	public function setPrevTemp($prevTemp)
	{
		$this->prevTemp = $prevTemp;
	}

	/**
	 * NEXTリンクのテンプレート設定
	 * ※REPLACE_TARGE_PAGE_NUM、REPLACE_TARGE_PAGE_NUMの文字列を内部で置換します。
	 *
	 * @access public
	 * @param $nextTemp
	 */
	public function setNextTemp($nextTemp)
	{
		$this->nextTemp = $nextTemp;
	}

	/**
	 * リンク先のテンプレート設定
	 * ※REPLACE_TARGE_PAGE_NUMの文字列を内部で置換します。
	 *
	 * @access public
	 * @param $hrefTemp
	 */
	public function setHrefTemp($hrefTemp)
	{
		$this->hrefTemp = $hrefTemp;
	}

	/**
	 * ページング
	 *
	 * 引数
	 * (int)$total : 対象データの総数
	 * (int)$count : 1ページに表示させたいデータの個数
	 * (int)$range : ページャーの表示個数
	 * (int)$pageID: ゲットしたpageIDパラメータ
	 */
	public function __construct($total, $count, $range, $pageID = null)
	{
		$this->setPagerItem($this->paging($total, $count, $range, $pageID));
		$this->setDefaultTemplate();
	}

	/**
	 * デフォルトテンプレートを設定
	 *
	 */
	private function setDefaultTemplate()
	{
		$this->pageTemp    = "<ul " . self::REPLACE_TARGE_ATTRIBUTE . ">" . self::REPLACE_TARGE_PAGE_ITEMS ."</ul>";
		$this->numTemp     = "<li><a href='" . self::REPLACE_TARGE_PAGE_HREF . "'>" . self::REPLACE_TARGE_PAGE_NUM . "</a></li>";
		$this->currentTemp = "<li><em>" . self::REPLACE_TARGE_PAGE_NUM . "</em></li>";
		$this->prevTemp    = "<li><a href='" . self::REPLACE_TARGE_PAGE_HREF . "'>&laquo; PREV</a>";
		$this->nextTemp    = "<li><a href='" . self::REPLACE_TARGE_PAGE_HREF . "'>NEXT &raquo;</a>";
		$this->hrefTemp    = self::REPLACE_TARGE_PAGE_NUM;
		$this->afterNumTemp = '';
		$this->beforNumTemp = '';
	}

	/**
	 * ページング
	 *
	 * 引数
	 * (int)$total : 対象データの総数
	 * (int)$count : 1ページに表示させたいデータの個数
	 * (int)$range : ページャーの表示個数
	 * (int)$pageID: ゲットしたpageIDパラメータ
	 */
	private function paging($total, $count, $range, $pageID = null)
	{
		// 現在のページ番号を取得する
		if(is_null($pageID) || $pageID == '' || !is_numeric($pageID))
		{
			$nowPage = 1;
		}
		else
		{
			$nowPage = $pageID ;
		}

		$pageCount = ceil((int)$total / (int)$count) ;			// 総ページ数
		$range = ($pageCount < $range)? $pageCount : $range ;	// ページャー表示個数

		// 開始ページを設定する
		if ($nowPage >= ceil((int)$range / 2))
		{
			$startPage = $nowPage - floor((int)$range / 2);
		}
		else
		{
			$startPage = 1;
		}

		// 開始ページが1未満の場合は、1にする
		$startPage = ($startPage < 1)? 1 : $startPage;

		// 最終ページを取得する
		(int)$endPage   = (int)$startPage + (int)$range - 1;
		if ($nowPage > $pageCount - ceil((int)$range / 2))
		{
			$endPage   = $pageCount ;
			$startPage = (int)$endPage - (int)$range + 1;
		}

		$limit = $count ;								// 1ページに表示するアイテム数
		$offset = ((int)$nowPage	 - 1) * $limit ;	// ofsetに設定する数

		$pager['limit']    = $count ;		// モデルに渡すlimit
		$pager['offset']   = $offset ;		// モデルに渡すoffset
		$pager['nowPage']  = $nowPage ;		// ビューに渡す現在表示中のページ
		$pager['startPage']= $startPage ;	// ビューに渡す始まりのページ
		$pager['endPage']  = $endPage ;		// ビューに渡す終わりのページ
		$pager['pageCount']= $pageCount ;	// ビューに渡す全ページング数
		$pager['link']     = range($startPage, $endPage ? $endPage : 1);	// ビューに渡すリンク

		return $pager;
	}

	/**
	 * ページングリンク作成
	 *
	 * 引数
	 * (string)$pageAttribute : 置換用文字列
	 *
	 */
	public function createPagerLink($pageAttribute = "")
	{
		$strPage = "";

		// PREVの表示判定
		if (1 < $this->pagerItem['nowPage'])
		{
			$strPage .= str_replace(self::REPLACE_TARGE_PAGE_NUM, $this->pagerItem['nowPage'] - 1, str_replace(self::REPLACE_TARGE_PAGE_HREF, $this->hrefTemp, $this->prevTemp));
		}

		$strPage .= $this->beforNumTemp;

		// ページャーの表示分リンクを生成する
		foreach ($this->pagerItem['link'] as $value)
		{
			if ($value == $this->pagerItem['nowPage'])
			{
				$strPage .= str_replace(self::REPLACE_TARGE_PAGE_NUM, $value, $this->currentTemp);
			}
			else
			{
				$strPage .= str_replace(self::REPLACE_TARGE_PAGE_NUM, $value, str_replace(self::REPLACE_TARGE_PAGE_HREF, $this->hrefTemp, $this->numTemp));
			}
		}

		$strPage .= $this->afterNumTemp;

		$this->isNextPage = false;

		//NEXTの表示判定
		if ($this->pagerItem['nowPage'] < $this->pagerItem['endPage'])
		{
			$this->isNextPage = true;

			$strPage .= str_replace(self::REPLACE_TARGE_PAGE_NUM, $this->pagerItem['nowPage'] + 1, str_replace(self::REPLACE_TARGE_PAGE_HREF, $this->hrefTemp, $this->nextTemp));
		}

		if ((int)$this->pagerItem['nowPage'] === (int)$this->pagerItem['endPage'])
		{
			$this->isNextPage = false;
		}

		$strPage = str_replace(self::REPLACE_TARGE_PAGE_ITEMS, $strPage, str_replace(self::REPLACE_TARGE_ATTRIBUTE, $pageAttribute, $this->pageTemp));
		$this->setLinkHtml($strPage);
	}
}