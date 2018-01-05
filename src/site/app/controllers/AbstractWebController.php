<?php

abstract class AbstractWebController extends ControllerBase
{
	public $genreList = array();
	public $json = array();

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 共通前処理（オーバーライド前提）
	 */
	protected function childPreAction()
	{
	}

	/**
	 * 共通前処理（オーバーライド前提）
	 */
	protected function preAction()
	{
		$this->view->assign('controller', $this->controller);
		$this->view->assign('action', $this->action);

		// サイトタイプ設定
		$this->view->assign('siteType', $this->siteType);

		// SEOタグ取得
		$seoYaml = WrapSpyc::getValueArray('seo');
		$seoList = null;

		// ymlに定義していない場合、defalutを使用する
		if (isset($seoYaml[$this->controller][$this->action]))
		{
			$seoList = $seoYaml[$this->controller][$this->action];
		}
		// コントローラが設定されている場合、1個目を使用する。
		else if (isset($seoYaml[$this->controller]))
		{
			foreach ($seoYaml[$this->controller] as $seo)
			{
				$seoList = $seo;
				break;
			}
		}
		else
		{
			$seoList = $seoYaml['defalut']['defalut'];
		}
		$this->view->assign('title', isset($seoList[0]) ? $seoList[0] : '');
		$this->view->assign('description', isset($seoList[1]) ? $seoList[1] : '');
		$this->view->assign('keywords', isset($seoList[2]) ? $seoList[2] : '');

		// ジャンル取得
		$this->genreList = WrapSpyc::getValueArray('genre');
		$this->view->assignByRef('genreList', $this->genreList);

		$this->childPreAction();

		// jsonデータ生成
		$json = $this->json;
		$json['APP_SETTING'] = array(
			'DEBUG' => DEBUG,
			'URL_ROOT' => URL_ROOT,
			'API_URL_COUNT' => API_URL_COUNT,
			'API_URL_COUNT_WORDS' => API_URL_COUNT_WORDS,
		);
		$this->view->assignByRef('json', $json);
	}

}