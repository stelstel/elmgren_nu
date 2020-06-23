<?php
/**
 * Config-file for Stelixx. Change settings here to affect installation.
 *
 */

/**
 * Set the error reporting.
 *
 */
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors 
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly


/**
 * Define Anax paths.
 *
 */
define('STELIXX_INSTALL_PATH', __DIR__ . '/..');
define('STELIXX_THEME_PATH', STELIXX_INSTALL_PATH . '/theme/render.php');


/**
 * Include bootstrapping functions.
 *
 */
include(STELIXX_INSTALL_PATH . '/src/bootstrap.php');


/**
 * Start the session.
 *
 */
session_name(preg_replace('/[^a-z\d]/i', '', __DIR__));
session_start();


/**
 * Create the Anax variable.
 *
 */
$stelixx = array();

/**
 * Site wide settings.
 *
 */
$stelixx['lang']         = 'sv';
$stelixx['title_append'] = ' | Stelixx en webbtemplate';

$stelixx['header'] = "<img class='sitelogo' src='img/sol.png' alt='Stelixx Logo'/>";
//$stelixx['header'] .= "<span class='sitetitle'>Blogg</span>";
//<span class='siteslogan'>Återanvändbara moduler för webbutveckling med PHP</span>


$menu = array(
	'callback' => 'modifyNavbar',
  		'items' => array(
    		'me'  => array('text'=>'Me',  'url'=>'me3.php?p=me', 'class'=>null),
    		'redovisning'  => array('text'=>'Redovisning',  'url'=>'redovisning2.php?p=redovisning', 'class'=>null),
    		'calendar' => array('text'=>'Knom 02', 'url'=>'manadens_babe.php?p=calendar', 'class'=>null),
			'filmdatabas' => array('text'=>'Knom 04', 'url'=>'kmom_04.php?p=filmdatabas', 'class'=>null),
			'lagra' => array('text'=>'Knom 05', 'url'=>'kmom_05.php?p=lagra', 'class'=>null),
			'source' => array('text'=>'Källkod', 'url'=>'kallkod.php?p=source', 'class'=>null),
  		),
);

$stelixx['links'] = <<<EOD
	<a href="kmom_05.php">Hem</a> 
	<a href="login.php">Logga in/Logga ut</a>
	<a href="newpost.php">Ny blogpost</a>
	<a href="newpage.php">Ny sida</a>
	<a href="blog.php">Visa alla blogposter</a>
	<a href="reset.php">Återställ databasen</a>		
EOD;

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Stefan Elmgren</span></footer>
EOD;

/**
 * Theme related settings.
 *
 */
$stelixx['stylesheets'] = array('css/style.css');
$stelixx['stylesheets'][] = 'css/links.css';
$stelixx['stylesheets'][] = 'css/nav.css';
$stelixx['favicon']    = 'img/sol.ico';

/**
 * Settings for JavaScript.
 *
 */
$stelixx['modernizr'] = 'js/modernizr.js';
$stelixx['jquery'] = '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js';
//$stelixx['jquery'] = null; // To disable jQuery
$stelixx['javascript_include'] = array();
//$stelixx['javascript_include'] = array('js/main.js'); // To add extra javascript files

/**
 * Google analytics.
 *
 */
$stelixx['google_analytics'] = 'UA-22093351-1'; // Set to null to disable google analytics

/**
 * Settings for the database.
 *
 */
 
// Local
/*
$stelixx['database']['dsn']            = 'mysql:host=localhost;dbname=kmom05;';
$stelixx['database']['username']       = 'stefanPluggar';
$stelixx['database']['password']       = 'ss3JV8oS';
$stelixx['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
*/

// BTH

// BTH
$stelixx['database']['dsn']            = 'mysql:host=db.elmgren.nu;dbname=wse647320;';
$stelixx['database']['username']       = 'wse647320';
$stelixx['database']['password']       = '8zHQ5ZjLVU';
$stelixx['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
