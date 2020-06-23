<?php

// Dumpar en array
function dump($array) {
  echo "<pre>" . htmlentities(print_r($array, 1)) . "</pre>";
}

?>
