<?php

/**
 * User: Théo
 * Date: 09/04/2021
 */

$pathToBasicWordpress = dirname(__FILE__) . '/../../..';
$pathToBedrockWordpress = dirname(__FILE__, 4) . '/wp';

$pathToWordpress = is_dir($pathToBedrockWordpress) ? $pathToBedrockWordpress : $pathToBasicWordpress;

$wpLoadFile = "{$pathToWordpress}/wp-load.php";
$wpPluginFile = "{$pathToWordpress}/wp-admin/includes/plugin.php";
$wpUpdateFile = "{$pathToWordpress}/wp-admin/includes/update.php";

if (!file_exists($wpLoadFile)) {
  throw new \Exception("The {$wpLoadFile} couldn't be found.");
}
if (!file_exists($wpPluginFile)) {
  throw new \Exception("The {$wpPluginFile} couldn't be found.");
}
if (!file_exists($wpUpdateFile)) {
  throw new \Exception("The {$wpUpdateFile} couldn't be found.");
}

require_once($wpLoadFile);
require_once($wpPluginFile);
require_once($wpUpdateFile);
require_once 'UpdateAlertCron.php';
require_once 'UpdateAlertAlert.php';
require_once 'UpdateAlertModule.php';

$cron = new UpdateAlertCron();

// At least one character to say "It's ok!"
echo 1;
