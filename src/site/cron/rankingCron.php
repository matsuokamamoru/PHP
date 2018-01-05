<?php

// ★define
require(realpath(__DIR__ . '/../configs/define.php'));

// core
require_once(DIR_FW . '/core/ArcClass.php');
require_once(DIR_FW . '/core/CronBase.php');

class rankingCron extends CronBase
{
	public function run()
	{
		try
		{
			(new RankingModel())->insert();
		}
		catch (Exception $ex)
		{
			Logger::error('ランキングデータ作成に失敗しました。');
			Logger::except($ex);
		}
	}

}

$cron = new rankingCron();
$cron->run();
