<?php

// ★define
require(realpath(__DIR__ . '/../configs/define.php'));

// core
require_once(DIR_FW . '/core/ArcClass.php');
require_once(DIR_FW . '/core/Dispatcher.php');

// libs
require(DIR_FW . '/libs/smarty/Smarty.class.php');

$dispatcher = new Dispatcher();
$dispatcher->dispatch();