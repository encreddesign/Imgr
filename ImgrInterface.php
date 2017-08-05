<?php

/*
* @interface - ImgrInterface
*/

require_once('ImgrImage.php');

public interface ImgrInterface {

  /*
  * @function: onImages
  * @params: ImgrImageObject $image
  */
  public function onImages (ImgrImage $image);

  /*
  * @function: onError
  * @params: String $failed
  */
  public function onError ($failed);

}

?>