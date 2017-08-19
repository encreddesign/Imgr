<?php

  /*
  * @author - Joshua Grierson
  * @update_at - 5/08/2017
  * @version - 0.1
  */

  require_once('ImgrInterface.php');

  class Imgr {

    /*
    * @var url
    */
    protected $_url;

    /*
    * @var headers
    */
    protected $_headers;

    /*
    * @var timeout
    */
    protected $_timeout;

    /*
    * @var status
    */
    protected $_status;

    /*
    * @var response
    */
    protected $_response;

    /*
    * @var object
    */
    protected $_object;

    /*
    * @var tag
    */
    private $_tag = 'img';

    /*
    * @var class
    */
    private $_class;

    /*
    * @var background
    */
    private $_background;

    /*
    * @var callback
    */
    private $_callback;

    private function __construct ($url, ImgrInterface $callback = null, $class = '', $background = false) {

      $this->_url = $url;
      $this->_headers = [
        'Content-Type' => 'text/html; charset=utf-8'
      ];
      $this->_timeout = 40;

      $this->_callback = $callback;
      $this->_class = $class;
      $this->_background = $background;

      $this->_object = new stdClass();

    }

    /*
    * @function: build
    */
    public function build () {

      try {

        if(!$this->_url) {
          throw new Exception('URL not provided');
        }

        $this->curlit();

        if(!$this->_response) {
          throw new Exception('Response from server was null');
        }

        if($this->_status >= 400) {
          throw new Exception('Server responded with '.$this->_status.' status');
        }

        $this->build_document();

      } catch (Exception $ex) {

        $error = $ex->getMessage();

        if($this->_callback) {
          $this->_callback->onError($error);
        }

        $this->_object->message = $error;

      }

      return $this;

    }

    /*
    * @function: build_document
    * @declaration: private
    */
    private function build_document () {

      $parser = new DOMDocument();
      $loaded = @$parser->loadHTML($this->_response);

      if(!$loaded) {
        throw new Exception('HTML Parsing failed');
      }

      $query = new DOMXpath($parser);

      $this->_object->images = $this->get_images($query);

    }

    /*
    * @function: get_images
    * @declaration: protected
    */
    protected function get_images (DOMXpath $query) {

      $return = [];
      $resultNodes = [];

      $queryNodes = null;
      $queryString = null;

      if($this->_class != '') {
        $queryString = $this->_tag."[contains(@class, '".$this->_class."')]";
      } else {
        $queryString = $this->_tag;
      }

      $resultNodes[$this->_tag] = $query->query("//".$queryString."");

      if($this->_background) {
        $queryString = "[contains(@style, 'background-image:')]";
      }

      $resultNodes['background'] = $query->query("//*".$queryString."");

      if(!is_null($resultNodes[$this->_tag])) {

        foreach($resultNodes[$this->_tag] as $element) {

          $url = $element->getAttribute('src');
          $return[] = $url;

          if($this->_callback) {
            $this->_callback->onImage(new ImgrImage($url, $element->getAttribute('alt')));
          }

        }

      }

      if(!is_null($resultNodes['background'])) {

        foreach($resultNodes['background'] as $element) {

          $url = $this->get_background_image($element);
          $return[] = $url;

          if($this->_callback) {
            $this->_callback->onImage(new ImgrImage($url, null));
          }

        }

      }

      return $return;

    }

    /*
    * @function: find_background_image
    * @declaration: protected
    */
    protected function get_background_image (DOMElement $element) {

      $styleTag = $element->getAttribute('style');

      if(!strpos($styleTag, 'url(')) {
        throw new Exception('Element does not have background image');
      }

      return preg_replace('/(\(|\)|url)/i', '', substr(
        $styleTag,
        strpos($styleTag, 'url('),
        strlen($styleTag)
      ));

    }

    /*
    * @function: curlit
    * @declaration: protected
    */
    protected function curlit () {

      $curl = curl_init();

      curl_setopt($curl, CURLOPT_URL, $this->_url);
      curl_setopt($curl, CURLOPT_HTTPHEADER, $this->_headers);
      curl_setopt($curl, CURLOPT_TIMEOUT, $this->_timeout);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

      if($this->is_ssl($this->_url)) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      }

      $this->_response = curl_exec($curl);
      $this->_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    }

    /*
    * @function: is_ssl
    * @declaration: protected
    */
    protected function is_ssl ($url) {

      if(substr($url, 0, 5) == 'https') {
        return true;
      }

      return false;

    }

    /*
    * @function: getImages
    * @declaration: public
    */
    public function getImages () {
      return $this->_object;
    }

    /*
    * @importance: Main
    * @function: forge
    * @declaration: protected
    */
    public static function forge ($url, ImgrInterface $callback = null, $class = '', $background = false) {
      return new static($url, $callback, $class, $background);
    }

  }

?>
