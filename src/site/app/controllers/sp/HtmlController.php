<?php

class HtmlController extends AbstractWebController
{
	public function indexAction()
	{
		// デフォルト以外のページの場合
		if (DEFAULT_CONTROLLER != $this->beforeController)
		{
			$this->templatePath = 'sp/html/' . $this->beforeController . '.tpl';

			if (file_exists($this->view->template_dir[0] . $this->templatePath) === false)
			{
				$this->templatePath = 'html/' . $this->beforeController . '.tpl';
			}
		}

		$response = array();

		if ($this->beforeController == 'agreement')
		{
			$response['gaSendPageView'] = "sp/利用規約";
		}

		$this->view->assignByRef('form', $response);
	}

}