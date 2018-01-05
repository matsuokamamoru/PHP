<?php

class TagsController extends APIControllerBase
{
	private $_result = array('status' => 'error');
	private $_model = null;

	protected function preAction()
	{
		$this->_model = new TagsModel();
	}

	public function addAction()
	{
		$data = array();
		$data['token'] = $this->request->getPost('token');
		$data['content_id'] = $this->request->getPost('content_id');
		$data['words'] = empty($this->request->getPost('words')) ? array() : explode(',', $this->request->getPost('words'));

		$response['error'] = $this->_model->validate($data);

		if (0 < count($response['error']))
		{
			$this->_result['error'] = $response['error'];
			return parent::putJson($this->_result);
		}

		try
		{
			$this->_model->insert($data);
			$this->_result['status'] = 'success';
		}
		catch (Exception $e) {}

		parent::putJson($this->_result);
	}

	public function tokenAction()
	{
		$this->_result['status'] = 'success';
		$this->_result['token'] = $this->_model->createTimeLimitedToken();

		parent::putJson($this->_result);
	}

}