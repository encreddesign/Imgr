<?php

  require_once('Imgr.php');
  require_once('ImgrCallback.php');

  Imgr::forge('http://jwlees.web.prop.cm/duttonschester/gallery/', new ImgrCallback(), 'zRS--slide')->build();

?>
