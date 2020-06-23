<?php
/**
 * Config-file for Anax. Change settings here to affect installation.
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
define('ANAX_INSTALL_PATH', __DIR__ . '/..');
define('ANAX_THEME_PATH', ANAX_INSTALL_PATH . '/theme/render.php');
 
 
/**
 * Include bootstrapping functions.
 *
 */
include(ANAX_INSTALL_PATH . '/src/bootstrap.php');
 
 
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
$anax = array();
 
 
/**
 * Site wide settings.
 *
 */
$anax['lang']         = 'sv';
$anax['title_append'] = ' | Anax en webbtemplate';