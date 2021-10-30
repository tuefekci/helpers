<?php
/**
 *
 * @copyright       Copyright (c) 2021. Giacomo Tüfekci (https://www.tuefekci.de)
 * @github          https://github.com/tuefekci
 * @license         https://www.tuefekci.de/LICENSE.md
 *
 */
require_once(realpath(__DIR__ . '/../vendor/autoload.php'));

$cli = new \tuefekci\helpers\Cli();
$cli->log("INFO", "dyntest1");
$cli->log("INFO", "dyntest2");
$cli->log("INFO", "dyntest3");
$cli->log("INFO", "dyntest4");
$cli->log("INFO", "dyntest5");

\tuefekci\helpers\Cli::log("DEBUG", "test1");
\tuefekci\helpers\Cli::log("INFO", "test2");
\tuefekci\helpers\Cli::log("NOTICE", "test3");
\tuefekci\helpers\Cli::log("WARNING", "test4");
\tuefekci\helpers\Cli::log("ERROR", "test5");
\tuefekci\helpers\Cli::log("CRITICAL", "test6");
\tuefekci\helpers\Cli::log("ALERT", "test7");
\tuefekci\helpers\Cli::log("EMERGENCY", "test8");

$cli = new \tuefekci\helpers\Cli();
$cli->log("INFO", "dyntest1");
$cli->log("INFO", "dyntest2");
$cli->log("INFO", "dyntest3");
$cli->log("INFO", "dyntest4");
$cli->log("INFO", "dyntest5");

