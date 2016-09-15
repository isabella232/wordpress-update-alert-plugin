<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 14/09/2016
 * Time: 14:06
 */

require_once(dirname(__FILE__).'/../../../wp-load.php');
require_once(dirname(__FILE__).'/../../../wp-admin/includes/plugin.php');
require_once(dirname(__FILE__).'/../../../wp-admin/includes/update.php');
require_once 'UpdateAlertCron.php';
require_once 'UpdateAlertAlert.php';
require_once 'UpdateAlertModule.php';

$cron = new UpdateAlertCron();

// At least one character to say "It's ok!"
echo 1;