<?php

class Logger
{
	/**
	 * ymlファイルの設定値
	 *
	 * @var array
	 * @access private staic
	 */
	private static $_loggerYaml = array();

	/**
	 * File name of log file(s) which output log
	 *
	 * @var array
	 * @access private staic
	 */
	private static $_fileNames = array();

	/**
	 * Format of log line
	 *
	 * @var string
	 * @access private staic
	 */
	private static $_logFormat = '[%time%] [%level%] %message%';

	/**
	 * Format of time in log line
	 *
	 * @var string
	 * @access private staic
	 */
	private static $_timeFormat = 'Y-m-d H:i:s';

	/**
	 * Max generation of log files
	 *
	 * @var integer
	 * @access private staic
	 */
	private static $_generation = 2;

	/**
	 * Max line count of log file
	 *
	 * @var integer
	 * @access private staic
	 */
	private static $_maxLine = 100000;

	/**
	 * Set file name to output log
	 *
	 * @access public staic
	 * @param string $fileName File name
	 * @param string $logKey Log key for file name
	 */
	public static function setLogName($fileName, $logKey = 'default')
	{
		self::$_fileNames[$logKey] = $fileName;
	}

	/**
	 * ログファイルの設定（初期ファイル）
	 *
	 * @access public staic
	 * @param string $addName 追加情報
	 * @param string $logKey Log key for file name
	 */
	public static function setDefaultLogName($addName = '', $logKey = 'default')
	{
		// ログ出力設定のyml取得
		self::$_loggerYaml= WrapSpyc::getValueArray('logger');

		// ログ出力するディレクトリを設定
		PathManager::setLogDirectory(DIR_LOG);

		// ディレクトリパス・ファイル名作成
		$process_date = date('Y/m/d H:i:s');
		$yyyy = date('Y', strtotime($process_date));
		$mm = date('m', strtotime($process_date));
		$dd = date('d', strtotime($process_date));
		$fileName = PathManager::getLogDirectory() . '/' . $yyyy . $mm . $dd . $addName . '.log';

		// ディレクトリ作成
		self::createDirectory(PathManager::getLogDirectory());

		// $_fileNamesにはフルパスで格納する
		self::$_fileNames[$logKey] = $fileName;
	}

	/**
	 * ディレクトリの作成
	 * 引数で指定したディレクトリが存在しなければ作成する
	 * 既に存在すれば何もしない。
	 * ディレクトリ作成に失敗した場合、実行時例外をスローする。
	 *
	 * @arg : $directory フォルダ名
	 * @return : true / false
	 */
	public static function createDirectory($directory)
	{
		if (is_dir($directory))
		{
			return true;
		}

		// 0775->
		// 所有者⇒読み込み、書き込み、実行の権限を与える
		// グループ⇒読み込み、書き込み、実行の権限を与える
		// 他人⇒読み込み、実行の権限を与える
		if (mkdir($directory, 0775))
		{
			return true;
		}

		return false;
	}

	/**
	 * Get file name to output log
	 *
	 * @access public staic
	 * @param string $logKey Log key for file name
	 * @return string
	 */
	public static function getLogName($logKey = 'default')
	{
		return self::$_fileNames[$logKey];
	}

	/**
	 * Set format of log line
	 *
	 * @access public staic
	 * @param string $format Format string of log line
	 */
	public static function setLogFormat($format)
	{
		self::$_logFormat = $format;
	}

	/**
	 * Set format of time in log line
	 *
	 * @access public staic
	 * @param string $format Format string of time in log line
	 */
	public static function setTimeFormat($format)
	{
		self::$_timeFormat = $format;
	}

	/**
	 * Set max line count of log file
	 *
	 * @access public staic
	 * @param integer $lineCount
	 */
	public static function setMaxLine($lineCount)
	{
		self::$_maxLine = $lineCount;
	}

	/**
	 * Set generation of log files
	 *
	 * @access public staic
	 * @param integer $generation
	 */
	public static function setGeneration($generation)
	{
		self::$_generation = $generation;
	}

	/**
	 * Output log
	 *
	 * @access public staic
	 * @param string $message Log message
	 * @param string $logLevel Log level string
	 * @param string $logKey Log key for file name
	 */
	public static function write($message, $logLevel = 'INFO ', $logKey = 'default')
	{
		if (!array_key_exists($logKey, self::$_fileNames))
		{
			return;
		}

		$filePath = self::$_fileNames[$logKey];
		if (file_exists($filePath) && is_file($filePath) && !is_writable($filePath))
		{
			return;
		}

		$logText = self::$_logFormat;
		$logText = str_replace('%time%', date(self::$_timeFormat), $logText);
		$logText = str_replace('%level%', $logLevel, $logText);
		$logText = str_replace('%message%', $message, $logText);
		$logText .= "\n";

		$lineCount = 0;
		if (file_exists($filePath))
		{
			$lineCount = count(file($filePath));
		}

		// exec rotate if line count of log file is over generation setting.
		if ($lineCount >= self::$_maxLine)
		{
			self::_rotate();
		}

		$r = @fopen($filePath, 'a');
		@fputs($r, $logText);
		@fclose($r);
	}

	/**
	 * Output log as information log
	 *
	 * @access public staic
	 * @param string $message Log message
	 * @param string $logKey Log key for file name
	 */
	public static function info($message, $logKey = 'default')
	{
		if(self::$_loggerYaml['info'])
		{
			self::write($message, 'INFO ', $logKey);
		}
	}

	/**
	 * Output log as warning message
	 *
	 * @access public staic
	 * @param string $message Log message
	 * @param string $logKey Log key for file name
	 */
	public static function warn($message, $logKey = 'default')
	{
		if(self::$_loggerYaml['warn'])
		{
			self::write($message, 'WARN ', $logKey);
		}
	}

	/**
	 * Output log as error message
	 *
	 * @access public staic
	 * @param string $message Log message
	 * @param string $logKey Log key for file name
	 */
	public static function error($message, $logKey = 'default')
	{
		if(self::$_loggerYaml['error'])
		{
			self::write($message, 'ERROR', $logKey);
		}
	}

	/**
	 * Output log as debug message
	 *
	 * @access public staic
	 * @param string $message Log message
	 * @param string $logKey Log key for file name
	 */
	public static function debug($message, $logKey = 'default')
	{
		if(self::$_loggerYaml['debug'])
		{
			self::write($message, 'DEBUG', $logKey);
		}
	}

	/**
	 * Output log as information of exception
	 *
	 * @access public staic
	 * @param string $message Log message
	 * @param string $logKey Log key for file name
	 */
	public static function except(Exception $e, $logKey = 'default')
	{
		$message = sprintf(
				"FILE:%s LINE:%s %s\n%s",
				$e->getFile(),
				$e->getLine(),
				$e->getMessage(),
				$e->getTraceAsString()
		);
		self::error($message, $logKey);
	}

	/**
	 * Execute log rotation
	 *
	 * @access private staic
	 */
	private static function _rotate()
	{
		$dirPath = PathManager::getLogDirectory();
		$fileName = self::$_fileNames[$logKey];

		// get file list in log directory
		$dir = dir($dirPath);
		$list = array();
		while ($content = $dir->read())
		{
			$path = sprintf("%s/%s", $dirPath, $content);
			if (!is_file($path))
			{
				// ignore directory
				continue;
			}

			$info = pathinfo($path);
			$name = $info['basename'];
			$ext = $info['extension'];

			if (!preg_match(sprintf('|^%s\.%s$|', $fileName, $ext), $name))
			{
				// ignore not match log name
				continue;
			}

			if ($ext >= self::$_generation)
			{
				// delete if rotate num is over generation setting
				@unlink($path);
			}
			else
			{
				$list[] = $info;
			}
		}

		// increment log extension as rotate num
		foreach ($list as $info)
		{
			$oldName = sprintf('%s/%s.%s', $dirPath, $fileName, $info['extension']);
			$newName = sprintf('%s/%s.%s', $dirPath, $fileName, ++$info['extension']);
			@rename($oldName, $newName);
		}

		@rename($filePath, $filePath . '.1');
		$dir->close();
	}
}