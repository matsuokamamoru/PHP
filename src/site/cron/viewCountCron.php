<?php

// ★define
require(realpath(__DIR__ . '/../configs/define.php'));

// core
require_once(DIR_FW . '/core/ArcClass.php');
require_once(DIR_FW . '/core/CronBase.php');

class viewCountCron extends CronBase
{
	public function run()
	{
		try
		{
			$model = new ViewCountModel();

			$data = $model->get();

			if (0 < count($data))
			{
				$model->update($data);
			}
		}
		catch (Exception $ex)
		{
			Logger::error('閲覧数更新バッチでエラーが発生しました。');
			Logger::except($ex);
		}
	}

}

$cron = new viewCountCron();
$cron->run();
