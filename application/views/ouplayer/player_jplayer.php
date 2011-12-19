<?php
/** Basic no-script Flash player, with caption support. Standalone or within a <noscript> tag.
*/
$base_url = base_url();

/*, "fullscreen":"Enter fullscreen mode"*/
$flowplayer_config = array( );

if ($standalone):
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?=$meta->title ?> | <?=t('OU player | jPlayer') ?></title>
	<meta charset="utf-8" />
	<meta name="copyright" value="&copy; 2011 The Open University" />
	<style>
	  body{ padding:0; margin:0; background:transparent; color:#000; overflow:hidden;}
	  object{ position:fixed; top:0; bottom:0; width:100%; height:100%}
	  #oup-fallback_links{display:none;}
	</style>
  <link type="text/css" href="<?=$base_url ?>jplayer/skin/jplayer.blue.monday.css" rel="stylesheet" />
	<script type="text/javascript" src="<?=$base_url ?>jplayer/jquery/1.6/jquery.min.js"></script>
	<script type="text/javascript" src="<?=$base_url ?>jplayer/jquery.jplayer.min.js"></script>
	<!--[if IE]>
	<style>._object{height:<?=$meta->object_height ?>px;}</style>
	<![endif]-->
</head>
<body>
<?php else: ?>
<div id="oup-fallback-div">
<?php endif; ?>

	<script src="<?=$base_url ?>assets/mediaelementjs/jquery.js"></script>
	<script src="<?=$base_url ?>assets/mediaelementjs/mediaelement-and-player.min.js"></script>
	<link rel="stylesheet" href="<?=$base_url ?>assets/mediaelementjs/mediaelementplayer.css" />
	
	<?php if ($meta->media_type=='video'): ?>	
	<video width="100%" id="mejsPlayer" poster="<?=$meta->poster_url ?>" controls="controls" preload="none">
		<!-- MP4 source must come first for iOS -->
		<source type="video/mp4" src="<?=$meta->media_url ?>" />
	  <?php if ($meta->caption_url): ?>
	  <!-- Optional: Add subtitles for each language (BH : believe this needs to be srt?) -->
	  <track kind="subtitles" src="<?=$meta->caption_url ?>" srclang="en" />
	  <?php endif;?>
		<!-- Fallback flash player for no-HTML5 browsers with JavaScript turned off -->
		<object width="100%" height="100%" type="application/x-shockwave-flash" data="<?=$base_url ?>/assets/mediaelementjs/flashmediaelement.swf">	
			<param name="movie" value="<?=$base_url ?>/assets/mediaelementjs/flashmediaelement.swf" /> 
			<param name="flashvars" value="controls=true&poster=<?=$meta->poster_url ?>&file=<?=$meta->media_url ?>" /> 		
			<!-- Image fall back for non-HTML5 browser with JavaScript turned off and no Flash player installed -->
			<img src="<?=$meta->poster_url ?>" width="100%" alt="Unable to play video" title="No video playback capabilities" />
	    <?php if (isset($inner)) echo $inner; ?>
		</object> 	
	</video>
	
	<?php else: ?>
	<audio width="100%" id="mejsPlayer" controls="controls" preload="none">
		<!-- MP4 source must come first for iOS -->
		<source type="audio/mp3" src="<?=$meta->media_url ?>" />
		<!-- Fallback flash player for no-HTML5 browsers with JavaScript turned off -->
		<object width="100%" height="30" type="application/x-shockwave-flash" data="<?=$base_url ?>/assets/mediaelementjs/flashmediaelement.swf">	
			<param name="movie" value="<?=$base_url ?>/assets/mediaelementjs/flashmediaelement.swf" /> 
			<param name="flashvars" value="controls=true&file=<?=$meta->media_url ?>" /> 		
			<!-- Image fall back for non-HTML5 browser with JavaScript turned off and no Flash player installed -->
			<img src="<?=$meta->poster_url ?>" width="100%" alt="Unable to play audio" title="No audio playback capabilities" />
	    <?php if (isset($inner)) echo $inner; ?>
		</object> 	
	</audio>
	
	<?php endif; ?>
	
	<script>
		// using jQuery
		//$('video,audio').mediaelementplayer(/* Options */);
		$('video,audio').mediaelementplayer({
			audioWidth: '100%'
		});
	</script>
	
	<div id="oup-fallback_links">
	  <a href="<?=$meta->media_url ?>">Download <?=$meta->title ?></a>
	</div>

<?php if ($standalone): ?>
</body>
</html>
<?php else: ?>
</div>
<?php endif;
