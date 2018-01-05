<?php

// ★define
require(realpath(__DIR__ . '/../configs/define.php'));

// core
require_once(DIR_FW . '/core/ArcClass.php');
require_once(DIR_FW . '/core/CronBase.php');

class twitterCron extends CronBase
{
	public function run()
	{
		try
		{
			(new SnsModel())->pushTwitter();
		}
		catch (Exception $ex)
		{
			Logger::error('twitter連携に失敗しました。');
			Logger::except($ex);
		}
	}

}

$cron = new twitterCron();
$cron->run();
