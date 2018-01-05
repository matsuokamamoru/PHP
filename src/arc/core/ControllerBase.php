<?php

abstract class ControllerBase
{
	protected $request = null;
	protected $siteType = SITE_TYPE_PC;
	protected $beforeController = '';
	protected $controller = DEFAULT_CONTROLLER;
	protected $action = DEFAULT_ACTION;
	protected $view  = null;
	protected $templatePath = '';

	public function __construct()
	{
		$this->request = new Request();
	}

	/**
	 * コントローラーとアクションの文字列設定
	 *
	 * @param string $siteType
	 * @param string $beforeController
	 * @param string $afterController
	 * @param string $action
	 */
	public function setControllerAction($siteType, $beforeController, $afterController, $action)
	{
		$this->siteType = $siteType;
		$this->beforeController = $beforeController;
		$this->controller = $afterController;
		$this->action = $action;
	}

	/**
	 * 処理実行
	 */
	public function run()
	{
		// ビューの初期化
		$this->initializeView();

		// 共通前処理
		$this->preAction();

		// アクションメソッド
		$methodName = sprintf('%sAction', $this->action);
		$this->$methodName();

		// 表示
		$this->view->display($this->templatePath);
	}

	/**
	 * ビューの初期化
	 */
	protected function initializeView()
	{
		// Smarty設定のyml取得
		$smartyYaml = WrapSpyc::getValueArray('smarty');

		// Smartyの初期化
		$this->view = new Smarty();
		$this->view->caching = $smartyYaml['caching'];
		$this->view->compile_check = $smartyYaml['compile_check'];
		$this->view->template_dir = sprintf('%s/templates/', PathManager::getViewDirectory());
		$this->view->compile_dir = sprintf('%s/templates_c/', PathManager::getViewDirectory());
		$this->view->config_dir = sprintf('%s/configs/', PathManager::getViewDirectory());
		$this->view->cache_dir = sprintf('%s/cache/', PathManager::getViewDirectory());
		$this->view->left_delimiter = $smartyYaml['left_delimiter'];
		$this->view->right_delimiter = $smartyYaml['right_delimiter'];
		$this->view->default_modifiers = array('escape:"html"');
		$this->templatePath = sprintf('%s/%s.tpl', $this->controller, $this->action);

		$mview = (new Cookie())->get('mview');

		// SmartPhoe ディレクトリ変更
		if (Dispatcher::$siteType === SITE_TYPE_SP && $this->_isExistsView() && ((is_null($mview) || $mview === 'off')))
		{
			$this->view->template_dir = sprintf('%s/templates/sp/', PathManager::getViewDirectory());
		}
	}

	/**
	 * 共通前処理（オーバーライド前提）
	 */
	protected function preAction()
	{
	}

	/**
	 * 画面遷移
	 *
	 * @param string $controller
	 * @param string $action
	 */
	protected function redirect($controller = null, $action = null)
	{
		if (is_null($controller) && is_null($action))
		{
			$url = URL_ROOT;
		}
		elseif (!is_null($controller) && is_null($action))
		{
			$url = URL_ROOT . $controller ;
		}
		else
		{
			$url =  URL_ROOT . $controller . '/' . $action;
		}

		header('Location: ' . $url);
		exit;
	}

	/**
	 * テンプレートファイル 存在チェック
	 *
	 * @return boolean
	 */
	private function _isExistsView()
	{
		$viewPath = sprintf('%s/templates/sp/%s/%s.tpl', PathManager::getViewDirectory(), $this->controller, $this->action);
		return file_exists($viewPath);
	}

}