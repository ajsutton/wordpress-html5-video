<?php
/*
 * Plugin Name: HTML5 Videos
 * Plugin URI: http://www.symphonious.net/
 * Version: 1.0
 * Description: Makes inserting self-hosted videos easy.
 * Author: Adrian Sutton
 * Author URI: http://www.symphonious.net/
 */

function html5Video_expandVideo($attrs) {
	extract(shortcode_atts(array(
		'src' => '',
		'type' => 'video/mp4; codecs="avc1.42E01E, mp4a.40.2',
		'mp4' => '',
		'webm' => '',
		'ogg' => '',
		'width' => '640',
		'height' => '360',
		'preload' => true,
		'autoplay' => "false",
		'poster' => plugins_url('poster.png', __FILE__)
	), $attrs));
	$sourceElements = "";
	$chromeSupport = false;
	if ($src != '') {
		$src = html5Video_absurl($src);
		$sourceElements = $sourceElements . "<source src='$src' type='$type' />\n";
	} else if ($mp4 != '') {
		$mp4 = html5Video_absurl($mp4);
		$src = $mp4;
		$sourceElements = $sourceElements . "<source src='$mp4' type='video/mp4; codecs=\"avc1.42E01E, mp4a.40.2\"' />\n";
	}
	if ($webm != '') {
		$chromeSupport = true;
		$webm = html5Video_absurl($webm);
		$sourceElements = $sourceElements . "<source src='$webm' type='video/webm; codecs=\"vp8, vorbis\"' />\n";
	}
	if ($ogg != '') {
		$chromeSupport = true;
		$ogg = html5Video_absurl($ogg);
		$sourceElements = $sourceElements . "<source src='$ogg' type='video/ogg; codecs=\"theora, vorbis\"' />\n";
	}
	if ($autoplay != "false") {
		$autoplayAttr = "autoplay=true";
	}
	if ($preload) {
		$preloadAttr = "preload=true";
	}
	$poster = html5Video_absurl($poster);
	$html = '<script>VideoJS.setupAllWhenReady();</script>';
	$flash = <<<END
      <object class="vjs-flash-fallback" width="$width" height="$height" type="application/x-shockwave-flash"
        data="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf">
        <param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" />
        <param name="allowfullscreen" value="true" />
        <param name="flashvars" value='config={"playlist":["$poster", {"url": "$src","autoPlay":$autoplay,"autoBuffering":true}]}' />
        <img src="$poster" width="$width" height="$height" alt="Poster Image"
          title="No video playback capabilities." />
      </object>
END;
	if (!$chromeSupport && is_chrome()) {
		$html = $html . $flash;
	} else {
		$html = $html . <<<END
<div class="video-js-box tube-css">
    <video class="video-js" width="$width" height="$height" controls="controls" $autoplayAttr $preloadAttr poster="$poster">
      $sourceElements
	  $flash
    </video>
    <p class="vjs-no-video"><strong>Download Video:</strong>
      <a href="$src">Download Video</a>,
    </p>
  </div>
END;
	}
	return $html;
}

function html5Video_absurl($url) {
	if (strpos($url, ':') < 0) {
		return home_url($url);
	} else {
		return $url;
	}
}

function is_chrome() {
	return(eregi("chrome", $_SERVER['HTTP_USER_AGENT']));
}

add_shortcode('video', 'html5Video_expandVideo');
wp_enqueue_script('video-js', plugins_url( '/video-js/video.js', __FILE__));
wp_enqueue_style('video-js', plugins_url('/video-js/video-js.css', __FILE__));
wp_enqueue_style('video-js-tube', plugins_url('/video-js/skins/tube.css', __FILE__));
?>
