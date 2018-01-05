<?php

// ★define
require(realpath(__DIR__ . '/../../configs/define.php'));

// core
require_once(DIR_FW . '/core/ArcClass.php');
require_once(DIR_FW . '/core/APIDispatcher.php');

$dispatcher = new APIDispatcher();
$dispatcher->dispatch();