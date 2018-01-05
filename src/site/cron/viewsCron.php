<?php

// ★define
require(realpath(__DIR__ . '/../configs/define.php'));

// core
require_once(DIR_FW . '/core/ArcClass.php');
require_once(DIR_FW . '/core/CronBase.php');

class ViewsCron extends CronBase
{
	private $_model = null;

	public function run()
	{
		try
		{
			$this->_model = new SidebarModel();

			// トップコンテンツ
			$this->_createTopContents();

			// 新着
			$this->_createNewVideos();

			// ランキング
			$this->_createRanking();

			// 話題のキーワード
			$this->_createHotWords();
		}
		catch (Exception $ex)
		{
			Logger::error('テンプレート作成、更新バッチでエラーが発生しました。');
			Logger::except($ex);
		}
	}

	private function _createTopContents()
	{
		$fileName = 'eyecatch.tpl';

		$data = $this->_model->findRanking();

		if ($data === false) return;

		// ファイル生成
		$templates = File::get(PathManager::getConfigDirectory() . '/templates/' . $fileName);

		$parts = '';

		$i = 0;
		foreach ($data as $item)
		{
			if ($i++ == 5) break;

			$thumbnailImgUrl = is_null($item['thumbnail_img_url']) ? '{$smarty.const.URL_ROOT}assets/images/180135.jpg' : $item['thumbnail_img_url'];
			$play_time = !is_null($item['play_time']) && $item['play_time'] !== '00:00' ? "<p class=\"play_time\">{$item['play_time']}</p>" : '';
			$rownum = "<p class=\"rank_number rank_number_{$item['rownum']}\">{$item['rownum']}</p>";

			$parts .= '
<div class="eyecatch_content eyecatch_content_1">
	<a href="{$smarty.const.URL_ROOT}detail/index/' . $item['content_id'] . '">
		' . $rownum . '
		<img alt="" class="lazy" data-original="' . $thumbnailImgUrl . '" width="180" height="135" />
		' . $play_time . '
		<p class="article_list_title"><span>{\'' . $item['title'] . '\'|truncate:20:\'...\'}</span></p>
	</a>
	<ul class="eyecatch_content_info clearfix">
		<li class="eyecatch_content_user"><a href="{$smarty.const.URL_ROOT}search' . (($item['genre_id'] != 0) ? '/genre/' . $item['genre_id'] : '') . '">{if isset($genreList[' . $item['genre_id'] . '])}{$genreList[' . $item['genre_id'] .']}{/if}</a></li>
	</ul>
</div>
';
		}

		$templates = str_replace('{@ranking}', $parts, $templates);

		// ファイル出力、コピー
		File::put(PathManager::getSystemRoot() . '/tmp/templates/' . $fileName, $templates);
		File::copy(
			PathManager::getSystemRoot() . '/tmp/templates/' . $fileName,
			PathManager::getViewDirectory() . '/templates/parts/' . $fileName
		);

	}

	private function _createNewVideos()
	{
		$fileName = 'newVideos.tpl';

		$data = $this->_model->findNewVideos();

		if (count($data) === 0) return;

		// ファイル生成
		$templates = File::get(PathManager::getConfigDirectory() . '/templates/' . $fileName);

		$parts = '
<div class="article_list_thumb" style="width:59px;">
	<a href="{$smarty.const.URL_ROOT}detail/new/{@content_id}">
		<img alt="" class="lazy" data-original="{@thumbnail_img_url}" width="50" height="38" />
	</a>
</div>
';

		$target = 0;

		for ($i = 1; $i <= 5; $i+=1)
		{
			$start = 0 + $target;
			$end = 4 + $target;

			$_parts = '';

			for ($j = $start; $j <= $end; $j+=1)
			{
				$__parts = $parts;
				if (($j + 1) % 5 == 0)
				{
					$__parts = str_replace('width:59px;', '', $__parts);
				}

				$_parts .= str_replace(
					array('{@content_id}', '{@thumbnail_img_url}'),
					array($data[$j]['content_id'], $data[$j]['thumbnail_img_url']),
					$__parts
				);
			}

			$templates = str_replace('{@newVideos' . $i . '}', $_parts, $templates);

			$target += 5;
		}

		// ファイル出力、コピー
		File::put(PathManager::getSystemRoot() . '/tmp/templates/' . $fileName, $templates);
		File::copy(
			PathManager::getSystemRoot() . '/tmp/templates/' . $fileName,
			PathManager::getViewDirectory() . '/templates/parts/sidebar/' . $fileName
		);

		// スマホ用のテンプレート生成
		$this->_createNewVideosSP($data);

	}

	private function _createNewVideosSP($data)
	{
		$fileName = 'newVideos.tpl';

		// ファイル生成
		$templatesSP = File::get(PathManager::getConfigDirectory() . '/templates/sp/' . $fileName);

		$parts = '';

		foreach ($data as $key => $item)
		{
			if (14 < $key) break;
			$parts .= '<li><a href="{$smarty.const.URL_ROOT}detail/new/' . $item['content_id'] . '">' . '<img alt="" src="' . $item['thumbnail_img_url'] . '" /></a></li>';
		}

		$templatesSP = str_replace('{@newVideos}', $parts, $templatesSP);

		// ファイル出力、コピー
		File::put(PathManager::getSystemRoot() . '/tmp/templates/sp/' . $fileName, $templatesSP);
		File::copy(
			PathManager::getSystemRoot() . '/tmp/templates/sp/' . $fileName,
			PathManager::getViewDirectory() . '/templates/sp/parts/' . $fileName
		);
	}

	private function _createRanking()
	{
		$fileName = 'ranking.tpl';

		$data = $this->_model->findRanking();

		if ($data === false) return;

		// ファイル生成
		$templates = File::get(PathManager::getConfigDirectory() . '/templates/' . $fileName);

		$parts = '';

		$i = 0;
		foreach ($data as $item)
		{
			if ($i++ == 5) break;

			$thumbnailImgUrl = is_null($item['thumbnail_img_url']) ? '{$smarty.const.URL_ROOT}assets/images/180135.jpg' : $item['thumbnail_img_url'];

			$parts .= '
<div class="article_list_content">
	<div class="article_list_thumb" style="width:60px;">
		<a href="{$smarty.const.URL_ROOT}detail/index/' . $item['content_id'] . '">
			<img alt="" class="lazy" data-original="' . $thumbnailImgUrl . '" width="50" height="38" />
			<span class="icon_rank">' . $i . '</span>
		</a>
	</div>
	<div class="article_list_text">
		<p class="side_article_title"><a href="{$smarty.const.URL_ROOT}detail/index/' . $item['content_id'] . '">{\'' . $item['title'] . '\'|truncate:40:\'...\'}</a></p>
		<p class="side_article_user"><a href="{$smarty.const.URL_ROOT}search' . (($item['genre_id'] != 0) ? '/genre/' . $item['genre_id'] : '') . '">{if isset($genreList[' . $item['genre_id'] . '])}{$genreList[' . $item['genre_id'] .']}{/if}</a></p>
	</div>
</div>
';
		}

		$templates = str_replace('{@ranking}', $parts, $templates);

		// ファイル出力、コピー
		File::put(PathManager::getSystemRoot() . '/tmp/templates/' . $fileName, $templates);
		File::copy(
			PathManager::getSystemRoot() . '/tmp/templates/' . $fileName,
			PathManager::getViewDirectory() . '/templates/parts/sidebar/' . $fileName
		);

		// スマホ用のテンプレート生成
		$this->_createRankingSP($data);

	}

	private function _createRankingSP($data)
	{
		$fileName = 'ranking.tpl';

		if ($data === false) return;

		// ファイル生成
		$templates = File::get(PathManager::getConfigDirectory() . '/templates/sp/' . $fileName);

		$parts = '';

		$i = 0;
		foreach ($data as $item)
		{
			if ($i++ == 5) break;

			$thumbnailImgUrl = is_null($item['thumbnail_img_url']) ? '{$smarty.const.URL_ROOT}assets/images/180135.jpg' : $item['thumbnail_img_url'];
			$play_time = !is_null($item['play_time']) && $item['play_time'] !== '00:00' ? "<p class=\"play_time\">{$item['play_time']}</p>" : '';
			$rownum = "<p class=\"rank_number rank_number_{$item['rownum']}\">{$item['rownum']}</p>";

			$parts .= '
<li>
<a href="{$smarty.const.URL_ROOT}detail/index/' . $item['content_id'] . '">
	<div class="list_thumb">
		<img width="120" height="90" data-original="' . $thumbnailImgUrl . '" class="lazy" alt="">
		' . $play_time . '
		' . $rownum . '
	</div>
	<div class="list_content">
		<h3><span>{\'' . $item['title'] . '\'|truncate:40:\'...\'}</span></h3>
		<div class="list_info">
			<p class="author">{if isset($genreList[' . $item['genre_id'] . '])}{$genreList[' . $item['genre_id'] . ']}{/if}</p>
		</div>
	</div>
</a>
</li>
';
		}

		$templates = str_replace('{@ranking}', $parts, $templates);

		// ファイル出力、コピー
		File::put(PathManager::getSystemRoot() . '/tmp/templates/sp/' . $fileName, $templates);
		File::copy(
			PathManager::getSystemRoot() . '/tmp/templates/sp/' . $fileName,
			PathManager::getViewDirectory() . '/templates/sp/parts/' . $fileName
		);

	}

	private function _createHotWords()
	{
		$fileName = 'hotword.tpl';

		$data = $this->_model->findHotWords();

		if (count($data) === 0) return;

		// ファイル生成
		$templates = File::get(PathManager::getConfigDirectory() . '/templates/' . $fileName);
		$templatesSP = File::get(PathManager::getConfigDirectory() . '/templates/sp/' . $fileName);

		$parts = '';
		foreach ($data as $key => $item)
		{
			$parts .= '<li class="tag"><a href="{$smarty.const.URL_ROOT}search/index/?q=' . $item['word'] . '">' . $item['word'] . '</a></li>';
		}
		$templates = str_replace('{@hotWords}', $parts, $templates);

		$partsSP = '';
		foreach ($data as $key => $item)
		{
			if (14 < $key) break;
			$partsSP .= '<li class="tag"><a href="{$smarty.const.URL_ROOT}search/index/?q=' . $item['word'] . '">' . $item['word'] . '</a></li>';
		}
		$templatesSP = str_replace('{@hotWords}', $partsSP, $templatesSP);

		// ファイル出力、コピー
		File::put(PathManager::getSystemRoot() . '/tmp/templates/' . $fileName, $templates);
		File::copy(
			PathManager::getSystemRoot() . '/tmp/templates/' . $fileName,
			PathManager::getViewDirectory() . '/templates/parts/sidebar/' . $fileName
		);

		File::put(PathManager::getSystemRoot() . '/tmp/templates/sp/' . $fileName, $templatesSP);
		File::copy(
			PathManager::getSystemRoot() . '/tmp/templates/sp/' . $fileName,
			PathManager::getViewDirectory() . '/templates/sp/parts/' . $fileName
		);
	}

}

$cron = new ViewsCron();
$cron->run();
