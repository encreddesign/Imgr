<?php

  require_once('Imgr.php');
  require_once('ImgrCallback.php');

  // if callback exists, callbck is called and passed with ImgrImage object
  Imgr::forge('http://example.domain.com/page/', new ImgrCallback(), 'gallery__image', true)->build();

  // return results as a plain object with array of images
  //$images = Imgr::forge('http://example.domain.com/page/', null, 'gallery__image', true)->build()->getImages();

?>
