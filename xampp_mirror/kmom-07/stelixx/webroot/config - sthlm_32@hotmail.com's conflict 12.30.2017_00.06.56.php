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
$stelixx['title_append'] = ' | Moviez';

$stelixx['header'] = "<img class='sitelogo' src='img/moviez.png' alt='Moviez Logo'/>";
$stelixx['header'] .= "<span class='siteslogan'>Sjyssta rullar för folk i farten</span>";

$stelixx['header'] .=<<<EOD
	<div style="text-align:center">    
 	<a href="index.php" >Hem</a> 
	<a href="filmer.php">Filmer</a>
	<a href="blog.php">Nyheter</a>
	<a href="om.php">Om</a>
	<a href="login.php">Logga in/ut</a>
	</div>
EOD;


$menu = array(
	'callback' => 'modifyNavbar',
  		'items' => array(
    		'me'  => array('text'=>'Me',  'url'=>'me3.php?p=me', 'class'=>null),
    		'redovisning'  => array('text'=>'Redovisning',  'url'=>'redovisning2.php?p=redovisning', 'class'=>null),
    		//'calendar' => array('text'=>'Knom 02', 'url'=>'manadens_babe.php?p=calendar', 'class'=>null),
			'calendar' => array('text'=>'Kmom 02', 'url'=>'http://elmgren.nu/xampp_mirror/stelixx/webroot/manadens_babe.php?p=calendar', 'class'=>null),
			'filmdatabas' => array('text'=>'Knom 04', 'url'=>'kmom_04.php?p=filmdatabas', 'class'=>null),
			//'filmdatabas' => array('text'=>'Kmom 04', 'url'=>'http://www.student.bth.se/~stel14/knom-04/stelixx/webroot/kmom_04.php?p=filmdatabas', 'class'=>null),
			//http://www.student.bth.se/~stel14/knom-04/stelixx/webroot/kmom_04.php
			'lagra' => array('text'=>'Kmom 05', 'url'=>'kmom_05.php?p=lagra', 'class'=>null),
			'galleri' => array('text'=>'Kmom 06', 'url'=>'gallery.php?p=galleri', 'class'=>null),
			'projekt' => array('text'=>'Kmom 07', 'url'=>'index.php?p=projekt', 'class'=>null),
			'source' => array('text'=>'Källkod', 'url'=>'kallkod.php?p=source', 'class'=>null),
  		),
);

$stelixx['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) Moviez</span></footer>
EOD;

/**
 * Theme related settings.
 *
 */
$stelixx['stylesheets'] = array('css/style.css');
$stelixx['stylesheets'][] = 'css/links.css';
$stelixx['stylesheets'][] = 'css/nav.css';

$stelixx['favicon']    = 'img/moviez.ico';


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
$stelixx['database']['dsn']            = 'mysql:host=mysql63.unoeuro.com;dbname=elmgren_nu_db;';
$stelixx['database']['username']       = 'elmgren_nu';
$stelixx['database']['password']       = '8zHQ5ZjLVU';
$stelixx['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
