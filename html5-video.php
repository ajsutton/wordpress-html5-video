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
		'type' => 'video/mp4',
		'width' => '640',
		'height' => '360',
		'poster' => plugins_url('poster.png', __FILE__)
	), $attrs));
	$src = home_url($src);
	$poster = home_url($poster);
	$html = '<script>VideoJS.setupAllWhenReady();</script>';
	$html = $html . <<<END
<div class="video-js-box tube-css">
    <video class="video-js" width="$width" height="$height" controls="controls" preload="auto" poster="$poster">
      <source src="$src" type="$type" />
      <object class="vjs-flash-fallback" width="$width" height="$height" type="application/x-shockwave-flash"
        data="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf">
        <param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" />
        <param name="allowfullscreen" value="true" />
        <param name="flashvars" value='config={"playlist":["$poster", {"url": "$src","autoPlay":false,"autoBuffering":true}]}' />
        <!-- Image Fallback. Typically the same as the poster image. -->
        <img src="$poster" width="$width" height="$height" alt="Poster Image"
          title="No video playback capabilities." />
      </object>
    </video>
    <p class="vjs-no-video"><strong>Download Video:</strong>
      <a href="$src">Download Video</a>,
    </p>
  </div>
END;
	return $html;
}

add_shortcode('video', 'html5Video_expandVideo');
wp_enqueue_script('video-js', plugins_url( '/video-js/video.js', __FILE__));
wp_enqueue_style('video-js', plugins_url('/video-js/video-js.css', __FILE__));
wp_enqueue_style('video-js-tube', plugins_url('/video-js/skins/tube.css', __FILE__));
?>
