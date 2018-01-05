<?php

class TopController extends AbstractWebController
{
	public function indexAction()
	{
		$pageNo = is_null($this->request->getParam('page_no')) ? 1 : $this->request->getParam('page_no');

		$model = new TopModel();
		$model->siteType = $this->siteType;
		$response = $model->find($pageNo);

		$response['gaSendPageView'] = "pc/トップ";

		$this->view->assignByRef('form', $response);
	}

}