<?php

  require_once( '../Imgr.php' );
  require_once('../ImgrCallback.php');

  // set response header type to json
  header('Content-Type', 'application/json');

  class Rest_Api {

    public function __construct () {
      $this->register();
    }

    private function register () {

      // make sure its post request
      if( $_SERVER['REQUEST_METHOD'] != 'POST' ) {
        $this->echo_response('Request type POST is required to access this endpoint', 405);
      }

      // make sure url param exists
      if( !isset($_POST['url']) ) {
        $this->echo_response('Url paramater is required', 400);
      }

      // is url exists make sure its a valid url for security
      $valid_url = $_POST['url'];
      if( !filter_var($valid_url, FILTER_VALIDATE_URL) ) {
        $this->echo_response('Url is invalid, going no further', 400);
      }

      Imgr::forge($valid_url, new ImgrCallback($this), 'gallery__image', true)->build();

    }

    // Response function
    public function echo_response ($message, $code) {

      header('Status', $code);
      die(
        json_encode([
          'message' => $message,
          'code' => $code
        ])
      );

    }

  }

  new Rest_Api();

?>
