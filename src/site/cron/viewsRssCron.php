<?php

// ★define
require(realpath(__DIR__ . '/../configs/define.php'));

// core
require_once(DIR_FW . '/core/ArcClass.php');
require_once(DIR_FW . '/core/CronBase.php');

class viewsRssCron extends CronBase
{
	public $key = null;
	public $url = null;

	private $_model = null;

	public function run()
	{
		try
		{
			$curl = new Curl();
			$curl->setOptions(array(
				CURLOPT_URL => $this->url,
				CURLOPT_HEADER => false,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_TIMEOUT => 60,
			));

			$data = $curl->getXmlContents();
			$this->_createRss($data);
		}
		catch (Exception $ex)
		{
			Logger::error('RSSテンプレート作成、更新バッチでエラーが発生しました。');
			Logger::except($ex);
		}
	}

	private function _createRss($data)
	{
		$fileName = 'rss' . $this->key . '.tpl';

		if ($data === false) return;

		// ファイル生成
		$templates = File::get(PathManager::getConfigDirectory() . '/templates/' . $fileName);

		$parts = '';

		$i = 0;
		foreach ($data->item as $item)
		{
			if ($i++ == 5) break;

			$parts .= '
			<div class="article_list_content">
				<div class="article_list_thumb" style="width:60px;">
					<a href="' . $item->link . '" target="_blank">
						<img alt="" class="lazy" data-original="' . $this->_getImagePath($item) . '" width="50" height="38" />
					</a>
				</div>
				<div class="article_list_text">
					<p class="side_article_title"><a href="' . $item->link . '" target="_blank">' . $item->title . '</a></p>
					<p class="side_article_user">' . $item->description . '</p>
				</div>
			</div>
';
		}

		$templates = str_replace('{@rss}', $parts, $templates);

		// ファイル出力、コピー
		File::put(PathManager::getSystemRoot() . '/tmp/templates/' . $fileName, $templates);
		File::copy(
			PathManager::getSystemRoot() . '/tmp/templates/' . $fileName,
			PathManager::getViewDirectory() . '/templates/parts/sidebar/' . $fileName
		);

		// スマホ用のテンプレート生成
		$this->_createRssSP($data);

	}

	private function _createRssSP($data)
	{
		$fileName = 'rss' . $this->key . '.tpl';

		if ($data === false) return;

		// ファイル生成
		$templates = File::get(PathManager::getConfigDirectory() . '/templates/sp/' . $fileName);

		$parts = '';

		$i = 0;
		foreach ($data->item as $item)
		{
			if ($i++ == 5) break;

			$parts .= '
			<li>
			<a href="' . $item->link . '" target="_blank">
				<div class="list_thumb">
					<img width="120" height="90" data-original="' . $this->_getImagePath($item) . '" class="lazy" alt="">
				</div>
				<div class="list_content">
					<h3><span>' . $item->title . '</span></h3>
				</div>
			</a>
			</li>
';
		}

		$templates = str_replace('{@rss}', $parts, $templates);

		// ファイル出力、コピー
		File::put(PathManager::getSystemRoot() . '/tmp/templates/sp/' . $fileName, $templates);
		File::copy(
			PathManager::getSystemRoot() . '/tmp/templates/sp/' . $fileName,
			PathManager::getViewDirectory() . '/templates/sp/parts/' . $fileName
		);

	}

	private function _getImagePath($item)
	{
		$result = '{$smarty.const.URL_ROOT}assets/images/180135.jpg';

		$node = $item->children('http://purl.org/rss/1.0/modules/content/');

		if (!isset($node)) return $result;

		preg_match_all('/<img.*?src=(["\'])(.+?)\1.*?>/i', $node->encoded, $matches);

		if ($this->key === 'Hatebu')
		{
			if (!isset($matches[2]) || count($matches[2]) !== 5) return $result;

			$result = $matches[2][1];
		}
		else if ($this->key === 'Eropon')
		{
			if (!isset($matches[2]) || count($matches[2]) !== 2) return $result;

			$result = $matches[2][0];
		}
		else
		{
			if (!isset($matches[2])) return $result;

			$result = $matches[2][0];
		}

		return $result;
	}

}

$cron = new viewsRssCron();
$cron->key = isset($argv[1]) ? $argv[1] : null;
$cron->url = isset($argv[2]) ? $argv[2] : null;
$cron->run();
