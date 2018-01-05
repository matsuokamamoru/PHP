<?php

class Dispatcher extends ArcClass
{
	private $_agentList = null;
	public static $siteType = SITE_TYPE_PC;

	public function __construct()
	{
		parent::__construct();

		// システムのルートディレクトリを設定
		PathManager::setSystemRoot(rtrim(DIR_ROOT, '/'));

		// ログファイルの設定（初期ファイル）
		Logger::setDefaultLogName();
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

		// １番目のパラメーターをコントローラーとして取得
		$beforeController = DEFAULT_CONTROLLER;
		if (0 < count($params))
		{
			if ($params[0] != '')
			{
				$beforeController = $params[0];
			}
		}

		// コントローラーの転送先を取得
		$afterController = $this->_getTransfer($beforeController);

		// １番目のパラメーターをもとにコントローラークラスインスタンス取得
		$controllerInstance = $this->_getControllerInstance($afterController);
		if (null == $controllerInstance)
		{
			throw new NotFoundException();
		}

		// ２番目のパラメーターをアクションとして取得
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
			throw new NotFoundException();
		}

		// コントローラー初期設定
		$controllerInstance->setControllerAction(self::$siteType, $beforeController, $afterController, $action);

		// 処理実行
		$controllerInstance->run();
	}

	/**
	 * コントローラーの転送先を取得
	 *
	 * @param string $beforeController
	 *
	 * @return 転送するコントローラー
	 */
	private function _getTransfer($beforeController)
	{
		$result = $beforeController;

		// コントローラ転送設定のyml取得
		$transferYaml = WrapSpyc::getValueArray('transfer');

		if (!isset($transferYaml))
		{
			return $result;
		}

		if (!isset($transferYaml[$beforeController]))
		{
			return $result;
		}

		$result = $transferYaml[$beforeController];

		return $result;
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
		// 一文字目のみ大文字に変換＋"Controller"
		$className = ucfirst(strtolower($controller)) . 'Controller';
		// スマートフォーン 判定
		$this->_settingSmartPhone();

		$tmpControllerPath = $controllerPath = '%s/app/controllers/%s.php';

		$mview = (new Cookie())->get('mview');

		if (self::$siteType === SITE_TYPE_SP && (is_null($mview) || $mview === 'off'))
		{
			$controllerPath = '%s/app/controllers/sp/%s.php';
			$controllerFileName = $this->_createControllerName($className, $controllerPath);
			if (!file_exists($controllerFileName))
			{
				$controllerPath = $tmpControllerPath;
			}
		}
		$controllerFileName = $this->_createControllerName($className, $controllerPath);

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

	/**
	 * スマホ判定
	 *
	 * @return int
	 */
	private function _settingSmartPhone()
	{
		if (is_null($this->_agentList))
		{
			$this->_agentList = WrapSpyc::getValueArray('mobile');
		}
		$pattern = '/' . implode('|', $this->_agentList['userAgents']) . '/i';
		if ( isset($_SERVER['HTTP_USER_AGENT']) && preg_match($pattern, $_SERVER['HTTP_USER_AGENT']) ) self::$siteType = SITE_TYPE_SP;
	}

	/**
	 * コントローラーPATH 生成
	 *
	 * @param  string $className
	 * @param  string $controllerPath
	 * @return string $controllerFileName
	 */
	private function _createControllerName($className, $controllerPath)
	{
		// コントローラーファイル名
		$controllerFileName = sprintf(
				$controllerPath,
				PathManager::getSystemRoot(),
				$className
		);
		return $controllerFileName;
	}

}