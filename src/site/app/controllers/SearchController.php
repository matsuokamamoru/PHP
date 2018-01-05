<?php

class SearchController extends AbstractWebController
{
	private $_model = null;

	protected function childPreAction()
	{
		$this->_model = new SearchModel();
		$this->_model->siteType = $this->siteType;
	}

	public function indexAction()
	{
		$words = str_replace('　', ' ', $this->request->getQuery('q'));

		$pageNo = is_null($this->request->getQuery('page_no')) ? 1 : $this->request->getQuery('page_no');

		$response = $this->_model->find(explode(' ', $words), $pageNo);

		$response['gaSendPageView'] = "pc/検索/$words";

		$this->view->assign('words', $words);
		$this->view->assignByRef('form', $response);
	}

	public function genreAction()
	{
		$genreId = $this->request->getParam('genre_id');

		if (is_null($genreId)) throw new NotFoundException();

		$pageNo = is_null($this->request->getParam('page_no')) ? 1 : $this->request->getParam('page_no');

		$response = $this->_model->findByGenre($genreId, $pageNo);

		$response['gaSendPageView'] = "pc/検索/{$this->genreList[$genreId]}";

		$this->templatePath = 'search/index.tpl';
		$this->view->assign('genreId', $genreId);
		$this->view->assign('genre', $this->genreList[$genreId]);
		$this->view->assignByRef('form', $response);
	}

}