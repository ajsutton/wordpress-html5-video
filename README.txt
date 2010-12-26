WordPress HTML 5 Video
======================

This is a very simple plugin that makes it easy for people who self-host both WordPress and their video files to display videos within blog posts or pages.  The plugin uses the very awesome LGPL VideoJS (http://videojs.com/) to do all the heavy lifting.

To display a video simply add a video shortcode:
[video src="movie.m4v" poster="posterImage.png" width=640 height=360 type="video/mp4"]

Only the src attribute is required.  The type defaults to video/mp4.  There is currently no support for providing multiple formats so for full compatibility (using the flash player fallback) MPEG4 should be used.

Copyright 2010 Adrian Sutton. Licensed under the LGPL - see included LICENSE.TXT file.
