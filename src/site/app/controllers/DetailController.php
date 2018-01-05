<?php

class DetailController extends AbstractWebController
{
	private $_model = null;

	protected function childPreAction()
	{
		$this->_model = new DetailModel();
		$this->_model->siteType = $this->siteType;
	}

	public function indexAction()
	{
		$contentId = $this->request->getParam('content_id');

		if (is_null($contentId)) throw new NotFoundException();

		$response = $this->_model->find($contentId);

		$response['gaSendPageView'] = "pc/コンテンツ/{$this->genreList[$response['contents'][0]['genre_id']]}/$contentId";

		$this->view->assignByRef('form', $response);
	}

	public function newAction()
	{
		$contentId = $this->request->getParam('content_id');

		if (is_null($contentId)) throw new NotFoundException();

		$response = $this->_model->findForNewVideos($contentId);

		$response['gaSendPageView'] = "pc/コンテンツ/新着";

		$this->templatePath = 'detail/index.tpl';
		$this->view->assignByRef('form', $response);
	}

}