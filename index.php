<?php

  require_once('Imgr.php');
  require_once('ImgrCallback.php');

  Imgr::forge('', new ImgrCallback(), 'wp-image-124', true)->build();

?>
