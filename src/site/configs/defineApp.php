<?php
/**
 * アプリケーション固有の設定値
 */

define('APP_VERSION', '201410181600');

// 集計APIのURL
define('API_URL_COUNT', 'http://' . DOMAIN_NAME . '/api/count/index/?content_id={0}&genre_id={1}');
define('API_URL_COUNT_WORDS', 'http://' . DOMAIN_NAME . '/api/count/words/?words={0}');

// ページング設定
define('TOP_ITEM_COUNT', 20);		// １画面あたりのアイテム表示数
define('TOP_PAGER_COUNT', 5);		// ページングの表示数

define('SEARCH_ITEM_COUNT', 20);
define('SEARCH_PAGER_COUNT', 5);

define('RANKING_ITEM_COUNT', 20);
define('RANKING_PAGER_COUNT', 5);

// ページング設定：スマホ
define('SP_TOP_ITEM_COUNT', 10);
define('SP_TOP_PAGER_COUNT', 5);

define('SP_SEARCH_ITEM_COUNT', 10);
define('SP_SEARCH_PAGER_COUNT', 5);

define('SP_RANKING_ITEM_COUNT', 10);
define('SP_RANKING_PAGER_COUNT', 5);

// OneTimeToken 有効時間
define('TOKEN_EXPIRE', '+10 minutes');
