<?php

require(DIR_FW . '/libs/securimage/Securimage.php');

class ImageController extends APIControllerBase
{
	public function securAction()
	{
		$img = new Securimage(array('code_length' => 4, 'charset' => '0123456789'));
		$img->show();
		exit;
	}

}