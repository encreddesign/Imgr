<?php

  /*
  * @class - ImgrImage
  */

  class ImgrImage {

    /*
    * @var src
    */
    private $_src;

    /*
    * @var alt
    */
    private $_alt;

    public function __construct ($src, $alt) {

      $this->_src = $src;
      $this->_alt = $alt;

    }

    /*
    * @function: getSrc
    */
    public function getSrc () {
      return $this->_src;
    }

    /*
    * @function: getAlt
    */
    public function getAlt () {
      return $this->_alt;
    }

    /*
    * @function: getSize
    */
    public function getSize () {

      $object = new stdClass();
      $image = getimagesize($this->_src);

      if(!$image) {
        return null;
      }

      list($width, $height, $type) = $image;

      $object->width = $width;
      $object->height = $height;
      $object->type = $type;

      return $object;

    }

  }

?>
