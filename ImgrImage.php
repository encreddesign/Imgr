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

  }

?>
