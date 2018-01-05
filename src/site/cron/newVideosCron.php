<?php

// ★define
require(realpath(__DIR__ . '/../configs/define.php'));

// core
require_once(DIR_FW . '/core/ArcClass.php');
require_once(DIR_FW . '/core/CronBase.php');

// It may take a whils to crawl a site ...
set_time_limit(120);

// Inculde the phpcrawl-mainclass
require_once DIR_FW . '/libs/phpcrawler/classes/phpcrawler.class.php';

// Extend the class and override the handleDocumentInfo()-method
class MyCrawler extends PHPCrawler
{
	public $links = array();

	public function handleDocumentInfo($DocInfo)
	{
		foreach ($DocInfo->links_found as $key => $link)
		{
			if (!preg_match('/(http:\/\/)(.*)(xvideos.com\/video)(.*)(asian|asians|japan|japanese|girl|girls|cutie|school|teen)(.*)/' , $link['url_rebuild']))
			{
				continue;
			}

			if (!preg_match('/(http:\/\/)(.*)(xvideos.com\/videos\/thumbs.*)(jpg|png)/' , $link['linkcode']))
			{
				continue;
			}

			foreach($this->links as $key => $_link)
			{
				if ($_link['url_rebuild'] === $link['url_rebuild'])
				{
					continue 2;
				}
			}
			$this->links[] = $link;
		}
	}

}

$crawler = new MyCrawler();

// URL to crawl
$crawler->setURL("http://jp.xvideos.com/");

$crawler->setPageLimit(3);

// Only receive content of files with content-type "text/html"
$crawler->addContentTypeReceiveRule("#text/html#");

// Ignore links to pictures, dont even request pictures
$crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png)$# i");

// Store and send cookie-data like a browser does
$crawler->enableCookieHandling(false);

// Every URL within the mysql-documentation looks like
// "http://www.php.net/manual/en/function.mysql-affected-rows.php"
// or "http://www.php.net/manual/en/mysql.setup.php", they all contain
// "http://www.php.net/manual/en/" followed by  "mysql" somewhere.
// So we add a corresponding follow-rule to the crawler.
$crawler->addURLFollowRule('/(http:\/\/)(.*)(xvideos.com\/home\/)([0-9])/');

// Thats enough, now here we go
$crawler->go();


class NewVideosCron extends CronBase
{
	public $links = array();

	public function run()
	{
		try
		{
			$model = new NewVideosModel();
			$model->insert($model->convert($this->links));
		}
		catch (Exception $ex)
		{
			Logger::error('新着動画取得バッチでエラーが発生しました。');
			Logger::except($ex);
		}
	}

}

$cron = new NewVideosCron();
$cron->links = $crawler->links;
$cron->run();
