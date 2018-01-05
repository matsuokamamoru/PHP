<?php

class CreateController extends AbstractWebController
{
	private $_post  = null;
	private $_model = null;

	public function childPreAction()
	{
		// Model Instance
		$this->_model = new CreateModel();

		// POST値を設定
		$this->_post  = $this->request->getPost();
	}

	public function indexAction()
	{
		$response = $this->_model->getData($this->_model->getSession());

		$response['gaSendPageView'] = "pc/投稿/入力";

		$this->view->assignByRef('form', $response);
	}

	public function confirmAction()
	{
		// validate Check
		$response['error'] = $this->_model->validate($this->_post);
		$formData = array_merge($response, $this->_post);

		// Session 突っ込む～
		$this->_model->setSession($formData);

		// Vlidate Error Check
		if (count($response['error']) > 0)
		{
			parent::redirect('create');
		}
		$formData['token']      = $this->_model->getToken();
		$formData['genre_name'] = $this->genreList[$this->_post['genre_id']];

		$_formData = $this->_model->convertMovingUrl($formData);

		$_formData['gaSendPageView'] = "pc/投稿/確認";

		$this->view->assignByRef('form', $_formData);
	}

	public function completeAction()
	{
		$formData = $this->_model->getSession();
		// validate Check
		$response['error'] = $this->_model->validateExec($this->_post);
		$formData = array_merge($response, $formData);

		// Error
		if (count($response['error']) > 0)
		{
			// Session 突っ込む～
			$this->_model->setSession($formData);
			parent::redirect('create');
		}

		$fileData = $this->_model->insert($formData);
		$this->_model->destroySession(array());
		$this->_model->writeContents($fileData);
		$this->redirect();
	}

}