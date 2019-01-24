<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// You can remove this if you are confident that your PHP version is sufficient.
if (version_compare(PHP_VERSION, '5.6.0') < 0) {
    trigger_error('Your PHP version must be equal or higher than 5.6.0 to use CakePHP.', E_USER_ERROR);
}

/*
 *  You can remove this if you are confident you have intl installed.
 */
if (!extension_loaded('intl')) {
    trigger_error('You must enable the intl extension to use CakePHP.', E_USER_ERROR);
}

/*
 * You can remove this if you are confident you have mbstring installed.
 */
if (!extension_loaded('mbstring')) {
    trigger_error('You must enable the mbstring extension to use CakePHP.', E_USER_ERROR);
}

/*
 * Configure paths required to find CakePHP + general filepath
 * constants
 */
require __DIR__ . '/paths.php';

/*
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CORE_PATH . 'config' . DS . 'bootstrap.php';

use Cake\Cache\Cache;
use Cake\Console\ConsoleErrorHandler;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;
use Cake\Database\Type;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorHandler;
use Cake\Log\Log;
use Cake\Mailer\Email;
use Cake\Network\Request;
use Cake\Utility\Inflector;
use Cake\Utility\Security;
use Cake\Routing\Router;

/*
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

/*
 * Load an environment local configuration file.
 * You can use a file like app_local.php to provide local overrides to your
 * shared configuration.
 */
//Configure::load('app_local', 'default');

/*
 * When debug = true the metadata cache should only last
 * for a short time.
 */
if (Configure::read('debug')) {
    Configure::write('Cache._cake_model_.duration', '+2 minutes');
    Configure::write('Cache._cake_core_.duration', '+2 minutes');
}

/*
 * Set server timezone to UTC. You can change it to another timezone of your
 * choice but using UTC makes time calculations / conversions easier.
 */
date_default_timezone_set('America/Chicago');

/*
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/*
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
ini_set('intl.default_locale', Configure::read('App.defaultLocale'));

/*
 * Register application error and exception handlers.
 */
$isCli = PHP_SAPI === 'cli';
if ($isCli) {
    (new ConsoleErrorHandler(Configure::read('Error')))->register();
} else {
    (new ErrorHandler(Configure::read('Error')))->register();
}

/*
 * Include the CLI bootstrap overrides.
 */
if ($isCli) {
    require __DIR__ . '/bootstrap_cli.php';
}

/*
 * Set the full base URL.
 * This URL is used as the base of all absolute links.
 *
 * If you define fullBaseUrl in your config file you can remove this.
 */
if (!Configure::read('App.fullBaseUrl')) {
    $s = null;
    if (env('HTTPS')) {
        $s = 's';
    }

    $httpHost = env('HTTP_HOST');
    if (isset($httpHost)) {
        Configure::write('App.fullBaseUrl', 'http' . $s . '://' . $httpHost);
    }
    unset($httpHost, $s);
}

Cache::config(Configure::consume('Cache'));
ConnectionManager::config(Configure::consume('Datasources'));
Email::configTransport(Configure::consume('EmailTransport'));
Email::config(Configure::consume('Email'));
Log::config(Configure::consume('Log'));
Security::salt(Configure::consume('Security.salt'));

/*
 * The default crypto extension in 3.0 is OpenSSL.
 * If you are migrating from 2.x uncomment this code to
 * use a more compatible Mcrypt based implementation
 */
//Security::engine(new \Cake\Utility\Crypto\Mcrypt());

/*
 * Setup detectors for mobile and tablet.
 */
Request::addDetector('mobile', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isMobile();
});
Request::addDetector('tablet', function ($request) {
    $detector = new \Detection\MobileDetect();

    return $detector->isTablet();
});

/*
 * Enable immutable time objects in the ORM.
 *
 * You can enable default locale format parsing by adding calls
 * to `useLocaleParser()`. This enables the automatic conversion of
 * locale specific date formats. For details see
 * @link http://book.cakephp.org/3.0/en/core-libraries/internationalization-and-localization.html#parsing-localized-datetime-data
 */
Type::build('time')
    ->useImmutable();
Type::build('date')
    ->useImmutable();
Type::build('datetime')
    ->useImmutable();
Type::build('timestamp')
    ->useImmutable();

/*
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 */
//Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
//Inflector::rules('irregular', ['red' => 'redlings']);
//Inflector::rules('uninflected', ['dontinflectme']);
//Inflector::rules('transliteration', ['/å/' => 'aa']);

/*
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on Plugin to use more
 * advanced ways of loading plugins
 *
 * Plugin::loadAll(); // Loads all plugins at once
 * Plugin::load('Migrations'); //Loads a single plugin named Migrations
 *
 */

/*
 * Only try to load DebugKit in development mode
 * Debug Kit should not be installed on a production system
 */
if (Configure::read('debug')) {
    Plugin::load('DebugKit', ['bootstrap' => true]);
}


Plugin::load('Admin');
Plugin::load('Website');

Configure::write('Theme', [
    'title' => 'DailyDoc',
    'logo' => [
        'mini' => '<span class="text-black">D</span><b>D</b>',
        'large' => '<span class="text-black">Daily</span><b>Doc</b>'
    ],
    'login' => [
        'show_remember' => false,
        'show_register' => false,
        'show_social' => false,
        'logo' => '<span class="text-black">Daily</span><span><b class="text-primary">Doc</b></span>',
    ],
    'folder' => ROOT
]);

Configure::write('BTN_DELETE_OPTIONS',[
    'class' => 'btn btn-xs btn-danger', 
    'escape' => false, 
    'data-toggle' => "confirmation",
    'data-btn-ok-label' => "Of course I am", 
    'data-btn-ok-icon' => "",
    'data-btn-ok-class' => "btn-success btn-padding",
    'data-btn-cancel-label' => "No nevermind!", 
    'data-btn-cancel-icon'=>"",
    'data-btn-cancel-class' => "btn-danger btn-padding",
    'data-title' => "Is it ok?",
    'data-content' => "This will flush the user permanently.",
    'data-placement' =>'left',
    'data-singleton' => 'true'
]);

Configure::write('GENDERS',[
    1 => 'Male',
    2 => 'Female'
]);

Configure::write('PATIENT_STATUS',[
    1 => 'Stable',
    2 => 'Unstable but improving',
    3 => 'May get unstable',
    4 => 'Unstable'
]);

Configure::write('PATIENT_PLACE',[
    1 => 'Home',
    2 => 'Group Home',
    3 => 'Assisted living',
    4 => 'TCU/Rehab',
    5 => 'NH',
    6 => 'Other Hospital',
    7 => 'Other',
]);

Configure::write('TIMEZONE', 'America/Chicago');

Configure::write('ACCESS_KEY', '123dailydocus!@#');

Configure::write('JWT_KEY', 'n1oyHNMK6zoXYritHah2hHIQZrto2e5L');

Configure::write('ALLOWED_IMAGE_EXTENSIONS',['image/png','image/jpeg','image/jpg']);

/* Firebase  Temp Acc */
Configure::write('defaultToken','9lwQWP4pdLz3Wy5I5FYTEGcLurmLZCMUX2YeqNaj');
Configure::write('defaultUrl','https://dailydoc-4f24e.firebaseio.com/');
Configure::write("serverkey", "AAAA3cZI768:APA91bEw37yUo1rJdo9CGuEpX93vIVhoI8AAuXb-JRgWlZVU9rPIytTXgtUsdycfZZTKgsRQ9hdq4TSbdoGWkvT4pUJ57kBWvYG5R_W7Zc4WE84TISWkok-2Y2PGFfDzjSQxGHW9CfYb");
/* Firebase  Temp */

/* Firebase  Local */
//Configure::write('defaultToken','CjG0yICCk3Emfm8EOMFVOfGHhYK2H5nqxVDbxmCC');
//Configure::write('defaultUrl','https://dailydoc-89796.firebaseio.com/');
/* Firebase  Local */

/* Firebase  Live */
Configure::write('FCMUrl', 'https://fcm.googleapis.com/fcm/send');
/* Configure::write('serverkey','AAAAjC-Bgv0:APA91bEuFb_bRp6U6t00oIuapILkQ8fOZkKb1PXXy6HJJo3iX4S_CLmfP2LEG6nLsC56iS8xW7jIVf7LRkLMgfoYYlYSDBMqmVvRLPJSIG6GJmGYbOX-pz9ZIsQfKb3OoUAdChK8D8lH');
Configure::write('defaultToken','CjG0yICCk3Emfm8EOMFVOfGHhYK2H5nqxVDbxmCC');
Configure::write('defaultUrl','https://dailydoc-89796.firebaseio.com/'); */
/* Firebase  Live */

Configure::write('Twilio',[
    'sid' => 'AC6e5ac8c21c8214c73e9869cbab393eec',
    'token' => 'fb5270ddc4e3c3e059152308afa0c437',
    'from' => '+16128000904'
]);

Configure::write('ADMIN_EMAIL','samrat.munde@bizmo-tech.com');
Configure::write('PASSWORD_EXPIRE_DAYS', 179);
/* Constants */
define("BASE_URL", Router::url('/repoDoc/',true));

Configure::write('DEFAULT_SUB_ADMIN','Default is sub admin');
Configure::write('NO_RECORD_FOUND','No Record Found.');
Configure::write('IMAGE_IDEAL_SIZE','<b>Note:</b> ideal size 160 x 160');

Configure::write('DEFAULT_USER_IMAGE_URL',BASE_URL.'admin/img/default.png');
Configure::write('DEFAULT_PATIENT_IMAGE_URL',BASE_URL.'admin/img/patient-default.png');

Configure::write('UPLOAD_USER_ORIGINAL_IMAGE_PATH',WWW_ROOT . "img/users/original/");
Configure::write('UPLOAD_USER_ORIGINAL_IMAGE_URL',BASE_URL . "img/users/original/");

Configure::write('UPLOAD_USER_THUMB_IMAGE_PATH',WWW_ROOT . "img/users/thumbs/");
Configure::write('UPLOAD_USER_THUMB_IMAGE_URL',BASE_URL . "img/users/thumbs/");

Configure::write('UPLOAD_EMPLOYEE_ORIGINAL_IMAGE_PATH',WWW_ROOT . "img/employees/original/");
Configure::write('UPLOAD_EMPLOYEE_ORIGINAL_IMAGE_URL',BASE_URL . "img/employees/original/");

Configure::write('UPLOAD_EMPLOYEE_THUMB_IMAGE_PATH',WWW_ROOT . "img/employees/thumbs/");
Configure::write('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL',BASE_URL . "img/employees/thumbs/");

Configure::write('UPLOAD_PATIENT_ORIGINAL_IMAGE_PATH',WWW_ROOT . "img/patients/original/");
Configure::write('UPLOAD_PATIENT_ORIGINAL_IMAGE_URL',BASE_URL . "img/patients/original/");

Configure::write('UPLOAD_PATIENT_THUMB_IMAGE_PATH',WWW_ROOT . "img/patients/thumbs/");
Configure::write('UPLOAD_PATIENT_THUMB_IMAGE_URL',BASE_URL . "img/patients/thumbs/");

Configure::write('UPLOAD_SIGNOUT_NOTE_PATH',WWW_ROOT . "audio/signout/");
Configure::write('UPLOAD_SIGNOUT_NOTE_URL',BASE_URL . "audio/signout/");

Configure::write('UPLOAD_MAJOR_EVENT_PATH',WWW_ROOT . "audio/major_event/");
Configure::write('UPLOAD_MAJOR_EVENT_URL',BASE_URL . "audio/major_event/");

Configure::write('EMAIL_LOGO', BASE_URL.'Admin/img/logos/logo.png');

/* SUCCESS Codes */
Configure::write('SUCCESS_CODE',200);
Configure::write('SUCCESS','Success');

/* ERROR Codes */
Configure::write('UNAUTHORIZED_CODE',401);
Configure::write('FORBIDDEN_CODE',403);
Configure::write('BAD_REQUEST_CODE',400);
Configure::write('SERVER_ERROR_CODE',500);

/* ERROR Messages */
Configure::write('UNAUTHORIZED','You are unauthorized to access this location.');
Configure::write('INVALID_HEADER_PARAMETER','Invalid header passed.');
Configure::write('INVALID_CREDENTIALS','Invalid credentials have been passed.');
Configure::write('INACTIVE_ACCOUNT','Your account is inactive. Contact Administrator.');
Configure::write('SERVER_ERROR','Oops ! Something went wrong.');
Configure::write('NO_ASSESSMENT_FOUND','No assessment found.');
Configure::write('INVALID_QUESTION','Invalid question has been passed.');
Configure::write('INVALID_ANSWERS','Invalid answers has been submitted.');
Configure::write('INVALID_INPUTS','Invalid inputs has been submitted.');
Configure::write('FORBIDDEN',"Forbidden! You don't have permission to access this url.");
Configure::write("INSUFFICIENT_ASSESSMENT", "Please pass an assessment.");
Configure::write("INSUFFICIENT_PARAMETERS", "Insufficient parameters have been passed.");
Configure::write("INVALID_USER", "Invalid user.");
Configure::write("LOGOUT", "Logout successfully.");
Configure::write("PATIENT_SAVE", "Patient save successfully.");
Configure::write("PATIENT_DELETE", "Patient has beeen deleted successfully.");
Configure::write("FOLLOWUPS_SAVE", "Patient followup has been saved successfully.");
Configure::write("NOTES_SAVE", "Patient note has been saved successfully.");
Configure::write("SIGNOUT_NOTE_SAVE", "Patient singout note has been saved successfully.");
Configure::write("EVENT_SAVE", "Patient major event has been saved successfully.");
Configure::write("REMINDER_SAVE", "Reminder has been saved successfully.");
Configure::write("MESSAGE_SAVE", "Message has been saved successfully.");
Configure::write("SCHEDULE_MESSAGE_SAVE", "Schedule message has been saved successfully.");
Configure::write("PLANE_SAVE", "Today plan has been saved successfully.");
Configure::write("NOTI_CHANGE", "Notification status has been changed successfully.");
Configure::write("REMINDER_CHANGE", "Reminder status has been changed successfully.");
Configure::write("FOLLOWUP_CHANGE", "Followup status has been changed successfully.");
Configure::write("MESSAGE_CHANGE", "Message status has been changed successfully.");
Configure::write("REMINDER_DELETE", "Reminder has been deleted.");
Configure::write("SIGNOUT_NOTE_DELETE", "Singout note has been deleted.");
Configure::write("MAJOR_EVENT_DELETE", "Major event has been deleted.");
Configure::write("FOLLOWUP_DELETE", "Followup has been deleted.");
Configure::write("NO_SERVICE_TEAM", "You haven't assigned any service team yet.");
Configure::write("CHAT_STATUS_CHANGE", "Chat status has been changed successfully.");
Configure::write("ROOM_NUMBER_CHANGE", "Room Number has been changed successfully.");
Configure::write("PCP_UPDATE", "PCP has been changed successfully.");
Configure::write("PRIMARY_MARKED", "Marked doctor as primary successfully.");
Configure::write("ADDED_CONSULT", "Doctor added in consult team successfully.");
Configure::write("ALREADY_IN_CONSULT", "Already added.");
Configure::write("CONSULT_TEAM_REMOVE", "Removed from consult team.");
Configure::write("MEMBER_NOT_FOUND", "Not Found.");
Configure::write("PATIENT_UPDATE", "Patient Information updated successfully.");
Configure::write("INVALID_TEAM", "Invalid Service Team Id.");
Configure::write("PRIMARY_REMOVED", "Removed from Primary.");