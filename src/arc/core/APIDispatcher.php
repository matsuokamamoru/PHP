<?php

class APIDispatcher extends ArcClass
{
	protected $type = 'api';

	public function __construct()
	{
		parent::__construct();

		// システムのルートディレクトリを設定
		PathManager::setSystemRoot(rtrim(DIR_ROOT, '/'));

		// ログファイルの設定（初期ファイル）
		Logger::setDefaultLogName('api');
	}

	/**
	 * 振分け処理実行
	 */
	public function dispatch()
	{
		$params = array();
		if ('' != $_SERVER['REQUEST_URI'])
		{
			// パラメーターを"/"で分割
			$params = explode('/', rtrim($_SERVER['REQUEST_URI'], '/'));
		}

		// 定義した値分、要素を削除
		$shift = DISPATCHER_SHIFT;
		for ($i = 1; $i <= $shift; $i++)
		{
			array_shift($params);
		}

		// １番目のパラメータ「ajax」を削除
		array_shift($params);

		// ２番目のパラメーターをコントローラーとして取得
		$controller = DEFAULT_CONTROLLER;
		if (0 < count($params))
		{
			if ($params[0] != '')
			{
				$controller = $params[0];
			}
		}

		// ２番目のパラメーターをもとにコントローラークラスインスタンス取得
		$controllerInstance = $this->_getControllerInstance($controller);
		if (null == $controllerInstance)
		{
			header('HTTP/1.0 404 Not Found');
			exit;
		}

		// ３番目のパラメーターをアクションとして取得
		$action= DEFAULT_ACTION;
		if (1 < count($params))
		{
			if ($params[1] != '')
			{
				$action = $params[1];
			}
		}

		// アクションメソッドの存在確認
		if (false == method_exists($controllerInstance, $action . 'Action'))
		{
			header('HTTP/1.0 404 Not Found');
			exit;
		}

		// コントローラー初期設定
		$controllerInstance->setControllerAction($controller, $action);

		// 処理実行
		$controllerInstance->run();
	}

	/**
	 * コントローラークラスのインスタンスを取得
	 *
	 * @param string $controller
	 *
	 * @return NULL|コントローラークラスのインスタンス
	 */
	private function _getControllerInstance($controller)
	{
		// 一文字目のみ大文字に変換＋"APIController"
		$className = ucfirst(strtolower($controller)) . 'Controller';

		// コントローラーファイル名
		$controllerFileName = sprintf(
			'%s/app/controllers/api/%s.php',
			PathManager::getSystemRoot(),
			$className
		);

		// ファイル存在チェック
		if (false == file_exists($controllerFileName))
		{
			return null;
		}

		// クラスファイルを読込
		require_once $controllerFileName;

		// クラスが定義されているかチェック
		if (false == class_exists($className))
		{
			return null;
		}

		// クラスインスタンス生成
		$controllerInstarnce = new $className();
		return $controllerInstarnce;
	}

}