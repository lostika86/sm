<?php
define('JPACKAGE_START_PATH',__DIR__);
define('JPACKAGE_VENDOR_PATH',JPACKAGE_START_PATH.'/vendor');
define('JPACKAGE_FORM_FIELDS',require_once __DIR__.'/mailer_config.php');

require_once JPACKAGE_VENDOR_PATH.'/lostika86/sm/src/SimpleMailer/mailer.php';

