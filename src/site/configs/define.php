<?php

date_default_timezone_set('Asia/Tokyo');

/**
 * ★デバッグ ※1にするとsmarty側でvar_dumpを出力します。通常は0。
 * 0:デバッグなし / 1:デバッグモード
 *
 * デバッグモードの場合、エラー処理がvar_dumpされる。
 * また、smarty側でのvar_dumpを切り替えたい場合、footerなどに以下を記述する。
 * {if $smarty.const.DEBUG == 1}{$form|@var_dump}{/if}
 */
define('DEBUG', 0);

// ★システムのドメイン名
define('DOMAIN_NAME', 'xvideos.matomes.net');
// ★システムのルートURL
define('URL_ROOT', '/');
// ★ルーティング設定
define('DISPATCHER_SHIFT', 1);
// ★デフォルト：コントローラ
define('DEFAULT_CONTROLLER', 'top');
// ★デフォルト：アクション
define('DEFAULT_ACTION', 'index');

// フレームワークのディレクトリパス
define('DIR_FW', realpath(__DIR__ . '/../../arc'));
// システムのルートディレクトリパス
define('DIR_ROOT', realpath(__DIR__ . '/..'));
// コントローラのディレクトリパス
define('DIR_CONTROLLER', DIR_ROOT . '/app/controllers');
// モデルのディレクトリパス
define('DIR_MODEL', DIR_ROOT . '/app/models');

// 自動読み込みするファイルのディレクトリパス
$array_difine = array('DIR_FW', 'DIR_CONTROLLER', 'DIR_MODEL');
define('DIR_ALL', serialize($array_difine));

// Smarty
define('SMARTY_THROUGH_ERROR', 'filemtime() [<a href=\'function.filemtime\'>function.filemtime</a>]:');
// PEAR_HTTP_OATUH
define('PEAR_HTTP_OATUH_THROUGH_ERROR', 'OAuth');

// ログのディレクトリパス
define('DIR_LOG', DIR_ROOT . '/logs');

// 一時ファイルのディレクトリパス
define('DIR_TMP', DIR_ROOT .'/tmp');

// セッションの要素名
define('SESSION_KEY', 'ARC');

// サイトタイプ デフォルトPCで定義
define('SITE_TYPE_PC', 'PC');

// サイトタイプ SmartPhone
define('SITE_TYPE_SP', 'SP');

require(realpath(__DIR__ . '/defineApp.php'));
