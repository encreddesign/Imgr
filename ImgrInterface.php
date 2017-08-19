<?php

  /*
  * @interface - ImgrInterface
  */

  require_once('ImgrImage.php');

  interface ImgrInterface {

    /*
    * @function: onImage
    * @params: ImgrImage $image
    */
    public function onImage (ImgrImage $image);

    /*
    * @function: onError
    * @params: String $failed
    */
    public function onError ($failed);

  }

?>
