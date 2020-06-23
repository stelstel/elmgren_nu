<?php 
/**
 * This is a Stelixx pagecontroller.
 *
 */
// Include the essential config-file which also creates the $stelixx variable with its defaults.
include(__DIR__.'/config.php');

$db = new CDatabase($stelixx['database']);
$t = new CTrash($db, "content");

$stelixx['title'] = "Trash";

$stelixx['main'] = $t->trashDel($_SERVER['QUERY_STRING']);

// Finally, leave it all to the rendering phase of Stelixx.
include(STELIXX_THEME_PATH);
