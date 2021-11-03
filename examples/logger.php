<?php
/**
 *
 * @copyright       Copyright (c) 2021. Giacomo Tüfekci (https://www.tuefekci.de)
 * @github          https://github.com/tuefekci
 * @license         https://www.tuefekci.de/LICENSE.md
 *
 */
require_once(realpath(__DIR__ . '/../vendor/autoload.php'));

\tuefekci\helpers\Cli::banner("blkhole", "https://github.com/tuefekci/blkhole");


$logger = new \tuefekci\helpers\Logger();


$logger->log("ERROR", "test8", ['exception' => new \Exception("test exception")]);