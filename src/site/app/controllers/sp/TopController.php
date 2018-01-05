<?php

class TopController extends AbstractWebController
{
	protected function childPreAction()
	{
		$pageNo = is_null($this->request->getParam('page_no')) ? 1 : $this->request->getParam('page_no');

		$model = new TopModel();
		$model->siteType = $this->siteType;
		$response = $model->find($pageNo);

		$response['gaSendPageView'] = "sp/トップ";

		$this->view->assignByRef('form', $response);
	}

	public function indexAction()
	{
	}

	public function loadAction()
	{
	}

}