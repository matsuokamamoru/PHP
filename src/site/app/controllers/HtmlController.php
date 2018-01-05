<?php

class HtmlController extends AbstractWebController
{
	public function indexAction()
	{
		// デフォルト以外のページの場合
		if (DEFAULT_CONTROLLER != $this->beforeController)
		{
			$this->templatePath = 'html/' . $this->beforeController . '.tpl';
		}

		$response = array();

		if ($this->beforeController == 'agreement')
		{
			$response['gaSendPageView'] = "pc/利用規約";
		}

		$this->view->assignByRef('form', $response);
	}

}