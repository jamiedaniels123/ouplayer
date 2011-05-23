<?php
/**Most controllers should extend this one.
 *
 * @copyright Copyright 2011 The Open University.
 */

class MY_Controller extends CI_Controller {

  /*public function __construct() {
    parent::__construct();
	var_dump(__CLASS__); exit;
  }*/

  /** Handle errors.
  */
  protected function _error($message, $code=500) {
    @header("HTTP/1.1 $code");
    die("$code. Error, $message");
  }

  /** Handle required GET parameters. */
  protected function _required($param) {
    $value = $this->input->get($param);
    if (!$value) {
      $this->_error("'$param' is a required URL parameter.", 400);
    }
    return $value;
  }

  /** Make relative URLs absolute. */
  protected function _absolute($url, $base_url) {
    if ($url && !parse_url($url, PHP_URL_SCHEME)) {
      return $base_url.'/'.$url;
    }
    return $url;
  }

}