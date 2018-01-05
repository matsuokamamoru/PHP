<?php

class CountController extends APIControllerBase
{
	private $_result = array('status' => 'error');
	private $_model = null;

	protected function preAction()
	{
		$this->_model = new CountModel();
	}

	public function indexAction()
	{
		$contentId = $this->request->getQuery('content_id');
		$genreId = $this->request->getQuery('genre_id');

		if (!is_null($contentId) && !is_null($genreId))
		{
			if ($this->_model->insertViewCount($contentId, $genreId) !== false &&
				$this->_model->insertViewCountDaily($contentId, $genreId) !== false)
			{
				$this->_result['status'] = 'success';
			}
		}

		parent::putJson($this->_result);
	}

	public function wordsAction()
	{
		$words = $this->request->getQuery('words');

		if (!is_null($words))
		{
			$words = str_replace('　', ' ', urldecode($words));

			if ($this->_model->insertHotWords(explode(' ', $words)) !== false)
			{
				$this->_result['status'] = 'success';
			}
		}

		parent::putJson($this->_result);
	}

}