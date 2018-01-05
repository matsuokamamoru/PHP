<?php

class ArcClass
{
	protected $type = null;
	private $_dirAll = null;
	private $_arrDirIterator = array();

	private $_noChkDirList = array('smarty', 'phpcrawler');
	private $_noChkClassList = array('PHPCrawler');
	private $_dbSqlClassList = array('AbstractSql', 'SqlExec', 'SqlHelper', 'SqlSelect');

	public function __construct()
	{
		$this->setHandler();

		spl_autoload_register(array($this, 'arc_loader'));
	}

	/**
	 * エラーハンドラ設定
	 */
	public function setHandler()
	{
		if (is_null($this->type))
		{
			set_exception_handler(array($this, 'arc_exception'));
			set_error_handler(array($this, 'arc_handler'));
		}
		else
		{
			set_exception_handler(array($this, 'arc_' . $this->type . '_exception'));
			set_error_handler(array($this, 'arc_' . $this->type . '_handler'));
		}
	}

	/**
	 * エラーハンドラ
	 *
	 * @param int $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param int $errline
	 * @throws Exception
	 */
	public function arc_handler($errno, $errstr, $errfile, $errline)
	{
		// Smarty内の関数（filemtime()）でエラーの場合は無視する
		// ※templates_cフォルダにキャッシュがないと起きる
		if($errno == 2 && strpbrk($errstr, SMARTY_THROUGH_ERROR))
		{
			return;
		}

		// OAuth内の2048ラーの場合は無視する
		if($errno == 2048 && strpos($errfile, PEAR_HTTP_OATUH_THROUGH_ERROR))
		{
			return;
		}

		throw new Exception($errno . ':' . $errstr);
	}

	/**
	 * 例外ハンドラ
	 *
	 * @param exception $ex
	 */
	public function arc_exception($ex)
	{
		// ログにエラー情報を書き込む
		Logger::except($ex);

		// セッション破棄
		(new Session(SESSION_KEY))->dispose();

		// デバッグモードの場合
		if (DEBUG == 1)
		{
			// ページにエラー情報を出力
			echo date('Y/m/d H:i:s');
			var_dump($ex->__toString());
		}
		else
		{
			switch (get_class($ex))
			{
				case 'NotFoundException':
					// 404ページへ飛ばす
					header('Location: ' . URL_ROOT . '404');
					exit;
					break;

				default:
					// エラーページへ飛ばす
					header('Location: ' . URL_ROOT . 'error');
					exit;
					break;
			}
		}

	}

	/**
	 * エラーハンドラ：api
	 *
	 * @param int $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param int $errline
	 * @throws Exception
	 */
	public function arc_api_handler($errno, $errstr, $errfile, $errline)
	{
		throw new Exception($errno . ':' . $errstr);
	}

	/**
	 * 例外ハンドラ：api
	 *
	 * @param exception $ex
	 */
	public function arc_api_exception($ex)
	{
		// ログにエラー情報を書き込む
		Logger::except($ex);

		// デバッグモードの場合
		if (DEBUG == 1)
		{
			// ページにエラー情報を出力
			echo date('Y/m/d H:i:s');
			var_dump($ex->__toString());
		}
	}

	/**
	 * エラーハンドラ：cron
	 *
	 * @param int $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param int $errline
	 * @throws Exception
	 */
	public function arc_cron_handler($errno, $errstr, $errfile, $errline)
	{
		throw new Exception($errno . ':' . $errstr);
	}

	/**
	 * 例外ハンドラ：cron
	 *
	 * @param exception $ex
	 */
	public function arc_cron_exception($ex)
	{
		// ログにエラー情報を書き込む
		Logger::except($ex);

		// デバッグモードの場合
		if (DEBUG == 1)
		{
			// ページにエラー情報を出力
			echo date('Y/m/d H:i:s');
			var_dump($ex->__toString());
		}
	}

	/**
	 * 指定したクラスを読み込む
	 *
	 * @param string $className
	 * @throws Exception
	 */
	public function arc_loader($className)
	{
		foreach ($this->_noChkClassList as $target)
		{
			if (strpos($className, $target) !== false) return;
		}

		$filePath = '';

		// 読み込み対象のフォルダを取得する
		if (is_null($this->_dirAll))
		{
			$this->_dirAll = unserialize(DIR_ALL);
		}

		$dirIterator = null;

		foreach ($this->_dirAll as $dir)
		{
			if (strpos($className, 'Model') !== false && $className !== 'ModelBase')
			{
				if ($dir !== 'DIR_MODEL') continue;
			}

			if (strpos($className, 'Sql') !== false && !in_array($className, $this->_dbSqlClassList))
			{
				if ($dir !== 'DIR_MODEL') continue;
			}

// 			if (!isset($this->_arrDirIterator[$dir]))
// 			{
				$dirIterator = new RecursiveDirectoryIterator(constant($dir));
				$iterator = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::LEAVES_ONLY, FilesystemIterator::SKIP_DOTS);
				$this->_arrDirIterator[$dir] = $iterator;
// 			}

			// 読み込み対象のフォルダ内に指定したクラスファイルが存在するかチェックする。
			foreach ($this->_arrDirIterator[$dir] as $file)
			{
				$isfile = false;

				// チェックしないリストの場合、次のループへ
				foreach ($this->_noChkDirList as $target)
				{
					if (strpos($file->getPath(), $target) !== false) continue 2;
				}

				$filePath = $file->getPath() . '/' . $className . '.php';

				$isfile = $this->_isFileExists($filePath);

				if (!$isfile)
				{
					$filePath = $file->getPath() . '/' . strtolower($className) . '.php';
					$isfile = $this->_isFileExists($filePath);
				}

				if (!$file->isDir() && $isfile)
				{
					require_once($filePath);
					return;
				}
			}
		}

		throw new Exception('指定されたファイルが存在しません。$filePath->' . $filePath);
	}

	/**
	 * ファイルの存在判定
	 *
	 * @param string $filePath
	 * @return boolean
	 */
	private function _isFileExists($filePath)
	{
		$result = false;
		if (file_exists($filePath))
		{
			$result = true;
		}

		return $result;
	}

}