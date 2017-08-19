<?php

  /*
  * @class - ImgrCallback
  */

  class ImgrCallback implements ImgrInterface {

    /*
    * @function: onImage
    */
    public function onImage (ImgrImage $image) {

      $src = $image->getSrc();
      $alt = $image->getAlt();

      $width = ($image->getSize() ? $image->getSize()->width : 0);
      $height = ($image->getSize() ? $image->getSize()->height : 0);

      echo sprintf('<img src="%s" alt="%s" width="%s" height="%s"/>', $src, $alt, $width, $height);

    }

    /*
    * @function: onError
    */
    public function onError ($failed) {
      echo sprintf('<p><b>Error Occurred:</b>%s</p>', $failed);
    }

  }

?>
