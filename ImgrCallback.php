<?php

  /*
  * @class - ImgrCallback
  */

  class ImgrCallback implements ImgrInterface {

    private $_restClass;
    private $_images;

    public function __construct (Rest_Api $restClass) {
      $this->_images = [];
      $this->_restClass = $restClass;
    }

    /*
    * @function: onImage
    */
    public function onImage (ImgrImage $image) {

      $src = $image->getSrc();
      $alt = $image->getAlt();

      $width = ($image->getSize() ? $image->getSize()->width : 0);
      $height = ($image->getSize() ? $image->getSize()->height : 0);

      // add image to array
      $object = new stdClass();
      $object->src = $src;
      $object->alt = $alt;
      $object->width = $width;
      $object->height = $height;

      $this->_images[] = $object;

    }

    /*
    * @function: onComplete
    */
    public function onComplete () {

      if(!empty($this->_images)) {
        $this->_restClass->echo_response(json_encode($this->_images), 200);
      } else {
        $this->_restClass->echo_response('No Images found', 204);
      }

    }

    /*
    * @function: onError
    */
    public function onError ($failed) {
      $this->_restClass->echo_response($failed, 500);
    }

  }

?>
