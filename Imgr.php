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

    private function __construct ($url, ImgrInterface $callback, $class = '', $background = '') {

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

        $this->build_regex();

      } catch (Exception $ex) {
        $this->_object->message = $ex->getMessage();
      }

      return $this;

    }

    /*
    * @function: build_regex
    */
    private function build_regex () {

      $imgs = [];
      $regex = '/\<img(.*?)>/i';

      preg_match_all($regex, $this->_response, $found);
      if(!empty($found) && isset($found[1])) {

        foreach($found[1] as $result) {

          preg_match('/src="(.*?)"/i', $result, $src);

        }

      }

      print_r($imgs);

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
    * @importance: Main
    * @function: forge
    * @declaration: protected
    */
    public static function forge ($url, $class = '', $background = '') {
      return new static($url, $class, $background);
    }

  }

?>
