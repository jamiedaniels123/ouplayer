<?php
/** Basic no-script Flash player, with caption support. Standalone or within a <noscript> tag.
*/
$base_url = base_url();

/*, "fullscreen":"Enter fullscreen mode"*/
$flowplayer_config = array( );

if ($standalone):
?>
<!DOCTYPE html><html lang="en"><meta charset="utf-8" /><title><?=$meta->title ?> | <?=t('OU player') ?></title>
<meta name="copyright" value="&copy; 2011 The Open University" />
<style>body{margin:0; background:#ffffff; color:#222; overflow:hidden} object{position:fixed; top:0; bottom:0; width:100%; height:100%} #oup-fallback_links{display:none;}</style>

<!--[if IE]>
<style>._object{height:<?=$meta->object_height ?>px;}</style>
<![endif]-->

<?php else: ?>

<div id="oup-fallback-div">
<?php endif; ?>


<objectx id="oup-fallback-obj" tabindex="0" aria-label="Video player" type="application/x-shockwave-flash"
 width="<?=$meta->width ?>" data-X-height="<?=$meta->object_height ?>"
 data="<?=$base_url ?>swf/flowplayer.commercial-3.2.7.swf">
 <param name="movie" value="<?=$base_url ?>swf/flowplayer.commercial-3.2.7.swf" />
 <param name="allowfullscreen" value="true" />
 <param name="allowscriptaccess" value="always" />
 <?php /*<param name="wmode" value="opaque" /><!--Important: wmode=opaque is not accessible, w/o Javascript controls!-->*/ ?>
<param name="flashvars" value='config={"key":["#$00c59a35083c836e7d5","#$73095eac474e4c39218"],
/*
*
*	Commented out params to style the player like open.edu there is an error in this lot but i cant spot it
*
"screen":{"height":"100pct","top":0},
"plugins":{"controls":{"timecolor":"rgba(255,="" 255,="" 1)"
,"borderradius":17,
"slowforward":true,
"buffergradient":"none",
"backgroundcolor":"rgba(0,="" 0,="" 0.5)",
"volumeslidergradient":"none",
"slowbackward":false,
"timeborderradius":20,
"progressgradient":"none",
"time":true,"height":26,
"volumecolor":"rgba(35,="" 148,="" 253,="" 1)",
"tooltips":{"stop":"stop",
"slowmotionfbwd":"fast="" backward",
"previous":"previous","next":"next",
"play":"play","buttons":true,
"slowmotionfwd":"slow="" forward",
"unmute":"unmute","pause":"pause",
"fullscreen":"fullscreen",
"marginbottom":5,
"slowmotionffwd":"fast="" forward",
"fullscreenexit":"exit="" fullscreen",
"volume":true,"scrubber":true,
"slowmotionbwd":"slow="" backward",
"mute":"mute"},"fastbackward":false,
"opacity":1,"timefontsize":12,
"buffercolor":"rgba(156,="" 229,="" 1)",
"border":"0px",
"volumeslidercolor":"rgba(0,="" 1)",
"buttoncolor":"rgba(156,="" 1)",
"mute":true,
"autohide":{"enabled":true,
"hidedelay":500,
"hidestyle":"fade",
"mouseoutdelay":500,
"hideduration":400,
"fullscreenonly":false},
"backgroundgradient":[0.5,0.2,0],
"width":"90pct",
"sliderborder":"1px="" solid="" rgba(128,="" 128,="" 0.7)",
"display":"block",
"buttonovercolor":"rgba(35,="" 1)",
"fullscreen":true,"timebgcolor":"rgba(0,="" 5,="" 0.5)",
"borderwidth":1,
"scrubberbarheightratio":0.2,
"bottom":"8pct25",
"stop":false,"zindex":1,
"slidercolor":"#000000",
"bordercolor":"rgba(105,="" 105,="" 0.5)",
"scrubberheightratio":0.6,
"tooltiptextcolor":"#ffffff",
"slidergradient":"none",
"timebgheightratio":0.7,
"volumesliderheightratio":0.6,
"name":"controls",
"timeseparator":"="" ",
"volumebarheightratio":0.2,"left":"50pct"
,"tooltipcolor":"#000000",
"playlist":false,
"durationcolor":"rgba(156,="" 1)",
"play":true,"fastforward":true,
"progresscolor":"rgba(35,="" 1)",
"timeborder":"0px="" rgba(0,="" 0.3)",
"volume":true,
"scrubber":true,
"volumeborder":"1px="" 0.7)",
"builtin":false}},
"canvas":{"backgroundcolor":"#000000",
"backgroundgradient":"none"},
*/
<?php if ($this->config->item('debug')): ?>
"log": {"level":"debug", "filter":"org.flowplayer.captions.*"},
"debug":false,
<?php endif; ?>
"playlist":[
<?php if ('video'==$meta->media_type && $meta->poster_url): ?>
{"url":"<?=$meta->poster_url ?>"},
<?php endif; ?>
{"url":"<?=$meta->media_url ?>", "autoPlay":false, "autoBuffering":false <?php if ($meta->caption_url): ?>
, 

 "captionUrl":"<?=$meta->caption_url ?>"<?php endif;?>}]
<?php /*"clip":{"url":"<?=$meta->media_url ?>", "autoPlay":false, "autoBuffering":true <?php if ($meta->caption_url): ?>
, "captionUrl":"<?=$meta->caption_url ?>"<?php endif;?>
}*/?>, "plugins":{
<?php if ($meta->caption_url): ?>
"captions":{"url":"flowplayer.captions-3.2.3.swf", "captionTarget":"content"},
"content": {
  "url":"flowplayer.content-3.2.0.swf",
<?php /*"width":"90%"<-?=($meta->width - 60) //Percent fails - why? */ ?>
  "bottom":30,
  "backgroundColor":"#000",
  "style": {
    "body":{
      "fontSize":15,
	  "textAlign":"center",
      "color":"#ffffff"
    }
  }
  <?php /*"width": "87%",
  "height":55,
  "backgroundColor": "#000",
  "backgroundGradient": "low",
  "border": 0,
  "borderRadius": 8,
  "textDecoration": "outline",
  "style":{
    "body":{
    "fontFamily":"Arial",
	"fontWeight":"bold",
	"fontSize":15,  
    "textAlign":"center",
	"color":"#ffffff"
    }
  }*/ ?>
},
<?php endif; ?>
"controls":{
"url":"flowplayer.controls-3.2.5.swf",
"bottom": "0",
"opacity": "0.8",
"tooltips":{
"buttons":true
}, "autoHide":false }}}' />
<?php if (isset($inner)) echo $inner; ?>
	<?php 
	if (end(explode('.', end(explode('/', $meta->media_url))))!='mp3'){
		echo "<video src=\"".$meta->media_url."\" autobuffer controls poster=\"".$meta->poster_url."\" width=\"480\" height=\"260\"></video>";
	}
	else{
		echo "<audio id=\"player2\" src=\"".$meta->media_url."\" type=\"audio/mp3\" controls=\"controls\"></audio>";
	}
	?>
</object>
	<script src="<?=$base_url ?>assets/mediaelementjs/jquery.js"></script>
	<script src="<?=$base_url ?>assets/mediaelementjs/mediaelement-and-player.min.js"></script>
	<link rel="stylesheet" href="<?=$base_url ?>assets/mediaelementjs/mediaelementplayer.css" />
<script>
$('audio,video').mediaelementplayer();
</script>

<?php if ($standalone): ?>
</html>
<?php else: ?>
</div>
<?php endif;
