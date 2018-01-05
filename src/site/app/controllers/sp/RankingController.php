<?php

class RankingController extends AbstractWebController
{
	protected function childPreAction()
	{
		$pageNo = is_null($this->request->getParam('page_no')) ? 1 : $this->request->getParam('page_no');

		$model = new RankingModel();
		$model->siteType = $this->siteType;
		$response = $model->find($pageNo);

		$response['gaSendPageView'] = "sp/ランキング";

		$this->view->assignByRef('form', $response);
	}

	public function indexAction()
	{
	}

	public function loadAction()
	{
	}

}