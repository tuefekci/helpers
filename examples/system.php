<?php
/**
 *
 * @copyright       Copyright (c) 2021. Giacomo Tüfekci (https://www.tuefekci.de)
 * @github          https://github.com/tuefekci
 * @license         https://www.tuefekci.de/LICENSE.md
 *
 */
require_once(realpath(__DIR__ . '/../vendor/autoload.php'));

var_dump(\tuefekci\helpers\System::isDocker());


$storage = \tuefekci\helpers\System::getStorage();

var_dump(\tuefekci\helpers\System::countCpuCores());
var_dump(\tuefekci\helpers\System::getCpuUsage());
var_dump(\tuefekci\helpers\System::getMemory());
var_dump(\tuefekci\helpers\System::getMemoryUsage());
var_dump(\tuefekci\helpers\System::getMemoryFree());
var_dump(\tuefekci\helpers\System::getMemoryAvailable());