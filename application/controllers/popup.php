<?php
/**
 * Pop-up/ pop-out player controller - very similar to the embed one!! NDF, 23 May 2011.
 * (Cf. http://youtube.com/watch_popup?v=um3s9IzMR4c)
 *
 * @copyright Copyright 2011 The Open University.
 */
require_once APPPATH.'libraries/ouplayer_lib.php';


class Popup extends MY_Controller { //CI_Controller {

  protected $_theme;
  protected $_debug;

  public function __construct() {
    parent::__construct();

	$this->_theme = $this->input->get('_theme') ? $this->input->get('_theme') :'basic'; #(basic|core|ouice-dark|ouice-bold)
	$this->_debug = $this->input->get('_debug');

	// For MSIE <= 6.5, downgrade the theme to 'basic' aka 'noscript'!
	$this->load->library('user_agent');
	if ($this->agent->is_browser('Internet Explorer') && $this->agent->version() < 7) {
		header("X-OUP-Requested-Theme: $this->_theme");
		$this->_theme = 'basic';
	}
  }

  /** OU-podcast player popup.
  */
  public function pod($custom_id=null, $shortcode=null) {
    if (!$custom_id || !$shortcode){
	  $this->_error("an album ID and track MD5 hash are required in the URL.", 400);
	}
	$width = 0; #$this->_required('width');
	$height= 0; #$this->_required('height');
	$audio_poster= $this->input->get('poster'); #Only for audio!

	$this->load->library('Oupodcast_serv');

	$player = $this->oupodcast_serv->_inner_call($custom_id, $shortcode);
	$player = $this->oupodcast_serv->get_transcript($player);

	$player->calc_size($width, $height, $audio_poster);

	$view_data = array(
        'meta' => $player,
        'theme'=> $this->_theme,
        'debug'=> $this->_debug,
        'standalone' => false,
		'mode' => 'popup',
    );

    if ('basic'!=$this->_theme || $edge) {
        $this->load->view('ouplayer/ouplayer', $view_data);
    } else {
        $view_data['standalone'] = true;
        $this->load->view('ouplayer/player_noscript', $view_data);
        // For now load vle_player - but, SWF is SAMS-protected!
        #$this->load->view('vle_player', $view_data);
	}
  }

  /** OUVLE player embed.
  */
  public function vle() {
    header('Content-Type: text/html; charset=utf-8');

    // Security: No access control required?

    // Process GET parameters in the request URL.
    $player = new Vle_player; #$request = (object) array(
    // Required.
    $player->media_url = $this->input->get('media_url');
    $player->title     = $this->_required('title');
    $player->width     = $this->_required('width');  # is_numeric. Required?
    $player->height    = $this->_required('height'); # Play height, not media(?)
    // Optional.
    $player->poster_url = $this->input->get('image_url');
    $player->caption_url= $this->input->get('caption_url');
    $player->language   = $this->input->get('lang'); #Just a reminder!
    #);

	//TODO: Need to tighten back up for production (Was: '/learn.open.ac.uk../')
    if (preg_match('/.open.ac.uk\/.*\.(mp4|flv|mp3)$/', $player->media_url, $ext)) { 
      // Codecs? http://wiki.whatwg.org/wiki/Video_type_parameters
      $opts = array('mp4'=>'video', 'flv'=>'video', 'mp3'=>'audio');
      $player->media_type = $opts[$ext[1]];
      $player->media_html5= 'flv'!=$ext[1];
    } else {
      $this->_error("'media_url' is a required parameter. (Accepts URLs ending mp4, flv and mp3.)", 400);
    }
    if ($player->caption_url && !preg_match('/\.(srt|xml|ttml)$/', $player->caption_url)) {
      $this->_error("'caption_url' accepts URLs ending srt, xml and ttml.", 400);
    }
    $base_url = dirname($player->media_url);
    $player->poster_url = $this->_absolute($player->poster_url, $base_url);
    $player->caption_url= $this->_absolute($player->caption_url, $base_url);

	$player->calc_size($player->width, $player->height, (bool)$player->poster_url);

    $view_data = array(
        'meta' => $player,
		'standalone' => true,
		'mode' => 'popup',
    );
	$this->load->view('ouplayer/player_noscript', $view_data);
    #$this->load->view('vle_player', $view_data); #$request);
  }

}
