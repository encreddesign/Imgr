<?php

  /*
  * @class - ImgrCallback
  */

  class ImgrCallback implements ImgrInterface {

    public function onImages (ImgrImage $image) {}

    public function onError ($failed) {}

  }

?>
