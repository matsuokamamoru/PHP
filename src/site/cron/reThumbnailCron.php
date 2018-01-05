<?php

// ★define
require(realpath(__DIR__ . '/../configs/define.php'));

// core
require_once(DIR_FW . '/core/ArcClass.php');
require_once(DIR_FW . '/core/CronBase.php');

// It may take a whils to crawl a site ...
set_time_limit(300);

// Inculde the phpcrawl-mainclass
require_once DIR_FW . '/libs/phpcrawler/classes/phpcrawler.class.php';
require_once DIR_FW . '/libs/phpcrawler/simplehtmldom/simple_html_dom.php';

// Extend the class and override the handleDocumentInfo()-method
class MyCrawler extends PHPCrawler
{
	public $thumbnailImgUrl = '';
	public $duration = null;

	public function handleDocumentInfo($DocInfo)
	{
		$html = str_get_html($DocInfo->source);
		if (!method_exists($html, 'find')) return;

		$ret = $html->find('#videoTabs img.thumb');
		if (!empty($ret) && count($ret) === 1)
		{
			foreach($ret as $element)
			{
				$this->thumbnailImgUrl = $element->src;
			}
		}

		$retDuration = $html->find('#main span.duration');
		if (!empty($retDuration) && count($retDuration) === 1)
		{
			foreach($retDuration as $element)
			{
				$this->duration = $element->plaintext;
			}
		}
	}

}


class ReThumbnailCron extends CronBase
{
	public function __construct()
	{
		parent::__construct();

		$this->_model = new ThumbnailModel();
	}

	public function run()
	{
		try
		{
			$media = $this->_model->findByImgUrlInNull();

			if (count($media) === 0) return;

			foreach ($media as $key => $item)
			{
				// ※一覧のリンクが一度リダイレクトするURLになっているため2ページクローリングする。
				$pageLimit = 2;

				$videoPath = null;
				preg_match('/(http:\/\/)(.*)(xvideos.com\/video)(.*)(\/)(.*)(\/)/' , $item['media'], $videoPath);

				if (empty($videoPath))
				{
					preg_match('/(http:\/\/)(.*)(xvideos.com\/video)(.*)(\/)/' , $item['media'], $videoPath);

					if (empty($videoPath))
					{
						// 取得できない画像はnullで更新する。
						if (empty($media[$key]['thumbnail_img_url']))
						{
							$media[$key]['thumbnail_img_url'] = null;
						}
						// 動画時間にデフォルト値を設定
						$media[$key]['duration'] = null;
						continue;
					}

					// ※詳細のURLだった場合、クローリングは1ページ
					$pageLimit = 1;
				}

				$videoId = $videoPath[4];

				$crawler = new MyCrawler();

				// URL to crawl
				$crawler->setURL(str_replace('www.xvideos.com', 'jp.xvideos.com', $item['media']));

				$crawler->setPageLimit($pageLimit);

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
				$crawler->addURLFollowRule('/(http:\/\/)(.*)(xvideos.com\/video' . $videoId . '\/)(.*)/');

				// Thats enough, now here we go
				$crawler->go();

				// 取得したサムネイル画像を設定
				if (empty($media[$key]['thumbnail_img_url']))
				{
					$media[$key]['thumbnail_img_url'] = $crawler->thumbnailImgUrl;
				}
				// 取得した動画時間を設定
				$media[$key]['duration'] = $crawler->duration;
			}

			// サムネイル画像のパスを更新
			$this->_model->update($this->_model->convert($media));
		}
		catch (Exception $ex)
		{
			Logger::error('再サムネイル画像更新バッチでエラーが発生しました。');
			Logger::except($ex);
		}
	}

}

$cron = new ReThumbnailCron();
$cron->run();
