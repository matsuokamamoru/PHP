<?php

abstract class APIControllerBase
{
	protected $request = null;
	protected $controller = DEFAULT_CONTROLLER;
	protected $action = DEFAULT_ACTION;

	public function __construct()
	{
		$this->request = new Request();
	}

	/**
	 * コントローラーとアクションの文字列設定
	 *
	 * @param string $controller
	 * @param string $action
	 */
	public function setControllerAction($controller, $action)
	{
		$this->controller = $controller;
		$this->action = $action;
	}

	/**
	 * 処理実行
	 */
	public function run()
	{
		// 共通前処理
		$this->preAction();

		// アクションメソッド
		$methodName = sprintf('%sAction', $this->action);
		$this->$methodName();
	}

	/**
	 * 共通前処理（オーバーライド前提）
	 */
	protected function preAction()
	{
	}

	/**
	 * json生成
	 *
	 * @return NULL
	 */
	protected function createJson()
	{
		return null;
	}

	/**
	 * json取得
	 *
	 * @return NULL
	 */
	protected function getJson()
	{
		return null;
	}

	/**
	 * json出力
	 *
	 * @param unknown_type $data
	 */
	protected function putJson($data)
	{
		header('Content-type: application/json; charset=UTF-8');
		echo json_encode($data);
	}
}