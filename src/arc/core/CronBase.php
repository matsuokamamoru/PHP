<?php

abstract class CronBase extends ArcClass
{
	protected $type = 'cron';

	public function __construct()
	{
		parent::__construct();

		// システムのルートディレクトリを設定
		PathManager::setSystemRoot(rtrim(DIR_ROOT, '/'));

		// ログファイルの設定（初期ファイル）
		Logger::setDefaultLogName('cron');
	}

	public abstract function run();

}