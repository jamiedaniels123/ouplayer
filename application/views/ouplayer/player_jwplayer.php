<?php
/** Basic no-script Flash player, with caption support. Standalone or within a <noscript> tag.
*/
$base_url = base_url();

/*, "fullscreen":"Enter fullscreen mode"*/
$flowplayer_config = array( );

if ($standalone):
?>
<!DOCTYPE html><html lang="en"><meta charset="utf-8" /><title><?=$meta->title ?> | <?=t('OU player | JW Player') ?></title>
<meta name="copyright" value="&copy; 2011 The Open University" />
<style>body{margin:0; background:#eee; color:#222; overflow:hidden;} object{position:fixed; top:0; bottom:0; width:100%; height:100%} #oup-fallback_links{display:none;}</style>

<!--[if IE]>
<style>._object{height:<?=$meta->object_height ?>px;}</style>
<![endif]-->
<body>
<?php else: ?>
<div id="oup-fallback-div">
<?php endif; ?>

	<script src="<?=$base_url ?>assets/jwplayer/jwplayer.js"></script>	
	
	<?php if ($meta->media_type=='video'): ?>
	<video id="jwPlayer"
		width="480"
		height="270"
		src="<?=$meta->media_url ?>"
	<?php if ($meta->poster_url!=""): ?>
		poster="<?=$meta->poster_url ?>">
	<?php endif; ?>
	</video>
	
	<script type="text/javascript">
		jwplayer("jwPlayer").setup({
			flashplayer: '<?=$base_url ?>assets/jwplayer/player.swf',
			skin: '<?=$base_url ?>assets/jwplayer/skins/glow/glow.zip'
		});
	</script>
	
	<?php else: ?>

	<div id="jwPlayer">Loading audio...</div>
	
	<script type="text/javascript">
		jwplayer("jwPlayer").setup({
			file: "<?=$meta->media_url ?>",
			width: '480',
			height: '30',
			flashplayer: '<?=$base_url ?>assets/jwplayer/player.swf',
			controlbar: 'bottom',
			skin: '<?=$base_url ?>assets/jwplayer/skins/glow/glow.zip',
			modes: [
			    {type: 'flash', src: '<?=$base_url ?>assets/jwplayer/player.swf'},
			    {
			      type: 'html5',
			      config: {
			       'file': '<?=$meta->media_url ?>',
			       'provider': 'sound'
			      }
			    },
			    {
			      type: 'download',
			      config: {
			       'file': '<?=$meta->media_url ?>',
			       'provider': 'sound'
			      }
			    }
				]
			});
	</script>

	<?php endif; ?>

	
	<div id="oup-fallback_links">
	  <a href="<?=$meta->media_url ?>">Download <?=$meta->title ?></a>
	</div>

<?php if ($standalone): ?>
</body>
</html>
<?php else: ?>
</div>
<?php endif;
