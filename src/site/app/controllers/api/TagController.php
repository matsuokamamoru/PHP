<?php
class TagController extends APIControllerBase
{

	private $_model = null;
	private $_result = array('status' => 'error');

	protected function preAction()
	{
		$this->_model = new TagModel();
	}

	public function addAction()
	{

		$data['tag_id']     = $this->request->getQuery('tag_id');
		$data['content_id'] = $this->request->getQuery('content_id');
		$data['word']       = $this->request->getQuery('word');

		// validator
		$response['error'] = $this->_model->validateAdd($data);
		// validator
		if (count($response['error']) > 0)
		{
			$this->_result['error'] = $response['error'];
			return parent::putJson($this->_result);
		}

		try
		{
			$this->_model->insert($data);
			$this->_result['status'] = 'success';
		}
		catch (Exception $e)
		{
		}

		return parent::putJson($this->_result);
	}

	public function deleteAction()
	{

		$data['tag_id']     = $this->request->getQuery('tag_id');
		$data['content_id'] = $this->request->getQuery('content_id');

		// validator
		$response['error'] = $this->_model->validateDelete($data);
		if (count($response['error']) > 0)
		{
			$this->_result['error'] = $response['error'];
			return parent::putJson($this->_result);
		}

		try
		{
			$this->_model->delete($data);
			$this->_result['status'] = 'success';
		}
		catch (Exception $e)
		{
		}

		return parent::putJson($this->_result);
	}

}