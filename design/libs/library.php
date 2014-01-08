<?php
	//////available functions:
	//* vimeoVid($vidID, $width, $height) - embed vimeo video. specify video ID, width and height
	//* youtubeVid($vidID, $width, $height) - embed vimeo video. specify video ID, width and height
	//* placeHolder($width, $height = '', $color = '', $text_color = '', $text = '') - creates a placeholder image. specify size, colors, and text.
	//* placeKitten($width, $height, $color) - create placeholder kitten
	//* flickr_bomb($search_term, $width, $height, $data_ratio = false, $img_id = false)
	//* randomAd($element, $imageDir, $srcArray, $hrefArray = false, $width = false, $height = false)
	//* embedSWF($swfFile, $swfID, $width, $height) - embed swf using swfobject.
	//* createNav($nav, $main, $footer) - create a navigation list. specify array to use and whether it is the main navigation or footer or neither (both false for neither).
	//* cleanLinks($string); - clean up any string to make it SEO-friendly url
	//* breadcrumbs($separator = ' &raquo; ', $home = 'Home');

// turn a list of filenames into links with a prefix
function styleTileLinks($options = 1, $abc) {
	$output = "<ul class='style-tile-links'>";
	$i = 0;

	while ($i < $options) {
		$output .= "<li><a href='/design/styletiles/styletile.php?option=" . $abc[$i] . "'>Option " . strtoupper($abc[$i]) . "</a></li>";
		$i++;
	}

	$output .= "</ul>";
	return $output;
}

function iframeTiles($tiles = 1, $abc) {
	$i = 0;
	$output = '';

	while ($i < $tiles) {
		$output .= '<iframe class="style-tile-iframe tile-' . ($i + 1) . '" src="styletile.php?option=' . $abc[$i] . '" frameborder="0"></iframe>';
		$i++;
	}

	return $output;
}

//embed vimeo video
function vimeoVid($vidID, $width, $height) {
	echo '<iframe src="http://player.vimeo.com/video/'.$vidID.'?title=0&amp;byline=0&amp;portrait=0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
}

//embed youtube video
function youtubeVid($vidID, $width, $height) {
	echo '<iframe title="YouTube video player" width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$vidID.'" frameborder="0" allowfullscreen></iframe>';
}

// insert placeholder image from placehold.it
function placeHolder($width, $height = '', $color = '', $text_color = '', $text = '', $float = '') {
	if(!empty($float)) {
		$float = 'class="float-'.$float.'" ';
	}
	echo "<img ".$float."src='http://placehold.it/".$width;
	if(!empty($height)) {
		echo "x".$height;
	}
	if(!empty($color)) {
		echo "/".$color;
	}
	if(!empty($text_color)) {
		echo "/".$text_color;
	}
	if(!empty($text)) {
		echo "&text=".$text;
	}
	echo "' />";
}

// insert placeholder image from placekitten.com
function placeKitten($width, $height, $color) {
	if($color) {
		echo "<img src='http://placekitten.com/".$width."/".$height."' />";
	} else {
		echo "<img src='http://placekitten.com/g/".$width."/".$height."' />";
	}
}

// insert placeholder image using flickr bomb
function flickr_bomb($search_term, $width, $height, $data_ratio = false, $img_id = false) {
	echo "<img ",($img_id ? "id ='$img_id'" : ""),"src='flickr://$search_term' ",($data_ratio ? "data-ratio='$data_ratio'" : "width='".$width."px' height='".$height."px' ")," />";
}

//embed SWF file (why?)
function embedSWF($swfFile, $swfID, $width, $height) {
echo <<< END
	<script type="text/javascript">
		swfobject.registerObject('$swfID', "9.0.115", "expressInstall.swf");
	</script>
	<object id='$swfID' classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width='$width' height='$height'>
		<param name="movie" value='$swfFile' />
		<!--[if !IE]>-->
		<object type="application/x-shockwave-flash" data='$swfFile' width='$width' height='$height'>
			<!--<![endif]-->
			<p>Alternative content</p>
			<!--[if !IE]>-->
		</object>
		<!--<![endif]-->
	</object>
END;
}

// randomize images in an ad spot
function randomAd($element, $imageDir, $srcArray, $hrefArray = false, $width = false, $height = false) {
	for($i = 0; $i < sizeof($srcArray); $i++) {
		$ext = end(explode('.', $srcArray[$i]));
		if(!empty($hrefArray[$i])) {
			echo "<div class='$i' style='display: none;'><a href='$hrefArray[$i]' target='_blank'><img src='$imageDir$srcArray[$i]' /></a></div>";
		} else if ($ext == "swf") {
			echo "<div class='$i' style='display: none;'><object width='$width[$i]' height='$height[$i]' <object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0'><param name='SRC' value='$imageDir$srcArray[$i]'><embed src='$imageDir$srcArray[$i]' width='$width[$i]' height='$height[$i]'></embed></object></div>";
		} else {
			echo "<div class='$i' style='display: none;'><img src='$imageDir$srcArray[$i]' /></div>";
		}
	}
	$imgArrayLength = sizeof($srcArray);
echo <<< END
	<script type="text/javascript">
	<!--
		$(function(){
			$('$element div').hide();
			var rndImg = Math.floor(Math.random() * $imgArrayLength);
			$('$element div.' + rndImg).show();
		});
	//-->
    </script>
END;
}

//* ==== create the nav based on the array given in the settings file ==== *//
function createNav($nav, $main, $footer) {
	global $footer_sections, $main_nav, $footer_nav;
	if($footer && $footer_sections) {
		for ($i = 0; $i < sizeof($nav); $i++) {
			if($i == 0) {
				$class = 'first';
			} else if ($i == (sizeof($nav)-1)) {
				$class = 'last';
			} else {
				$class = '';
			}
			echo "<ul class='$class nav'>";
				setupListItem($nav[$i], $i, sizeof($nav), $main, $footer);
			echo "</ul>";
		}
	} else {
		echo "<ul class='nav'>";
		for ($i = 0; $i < sizeof($nav); $i++) {
			setupListItem($nav[$i], $i, sizeof($nav), $main, $footer);
		}
		echo "</ul>";
	}
}

function setupListItem($value, $index, $size, $isMain, $isFooter) {
	global $footer_sections;
	if(is_array($value)) {
		if(strtolower($value[0]) == "home") {
			$link = "./";
		}
		 else {
			$link = cleanLinks($value[0]);
		}
		if($index == 0) {
			$class = 'top-first';
		} else if ($index == ($size-1)) {
			$class = 'top-last';
		} else {
			$class = '';
		}
		if($isMain) {
			echo "<li class='$class dropMenu'><a href='$link'>$value[0]</a><ul>";
		} else if($isFooter && $footer_sections) {
			echo "<li class='top-first'><a href='$link'>$value[0]</a>";
		}
		for($i = 1; $i < sizeof($value); $i++) {
			$isFirst = (($isMain || ($isFooter && $footer_sections)) && $i == 1) ? true : false;
			if ((($isMain || ($isFooter && $footer_sections)) && ($i == (sizeof($value) - 1))) || (($isFooter && !$footer_sections) && (($index == ($size-1))&&($i == (sizeof($value) - 1))))) {
				$isLast = true;
			} else {
				$isLast = false;
			}
			linkOutput($value[$i], false, $isFirst, $isLast);
		}
		if ($isMain) {
			echo "</ul>";
		}
	} else {
		$isFirst = ($index == 0) ? true : false;
		$isLast = ($index == ($size - 1)) ? true : false;
		$top = ($isMain) ? true : false;
		linkOutput($value, $top, $isFirst, $isLast);
	}
}

function linkOutput($value, $top, $isFirst, $isLast) {
	global $company_name, $facebook_addy, $twitter_addy, $linkedin_addy;
	if($isFirst) {
		if($top) {
			$liopen = "<li class='top-first'";
		} else {
			$liopen = "<li class='first'";
		}
	} else if($isLast) {
		if($top) {
			$liopen = "<li class='top-last'";
		} else {
			$liopen = "<li class='last'";
		}
	} else {
		$liopen = "<li";
	}
	if($value == "facebook" || $value == "twitter" || $value == "linkedin") {
		if($value == "facebook") {
			$socialid = "fblink";
			$sociallink = $facebook_addy;
			$socialtitle = "Join $company_name on Facebook!";
		} else if($value == "twitter") {
			$socialid = "twlink";
			$sociallink = $twitter_addy;
			$socialtitle = "Follow $company_name on Twitter!";
		} else if($value == "linkedin") {
			$socialid = "lilink";
			$sociallink = $linkedin_addy;
			$socialtitle = "Join $company_name on LinkedIn!";
		}
		echo "$liopen><a id='$socialid' class='social' href='$sociallink' title='$socialtitle' target='_blank'>$socialtitle</a></li>";
	} else {
		if(strtolower($value) == "home") {
			$link = "/design/wireframes/";
		}
		 else {
			$link = cleanLinks($value);
		}
		echo "$liopen><a href='$link'>$value</a></li>";
	}
}

function cleanLinks($string) {
	$link_formatted = str_replace(".", "", $string);
	$link_formatted = str_replace("?", "", $link_formatted);
	$link_formatted = preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $link_formatted);
	$link_formatted = strtolower($link_formatted);
	return "/design/wireframes/" . "$link_formatted";
}

function formatString($string) {
	$string_formatted = str_replace(".", "", $string);
	$string_formatted = str_replace("?", "", $string_formatted);
	$string_formatted = preg_replace(array('/[^a-z0-9-]/i', '/[ ]{2,}/', '/[ ]/'), array(' ', ' ', '-'), $string_formatted);
	$string_formatted = strtolower($string_formatted);
	return "$string_formatted";
}
// end nav stuff

// create breadcrumbs based on site structure
function breadcrumbs($separator = ' &raquo; ', $home = 'Home') {
	// This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
	$path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));

	$secure_connection = false;

	if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) {
		$secure_connection = true;
	}

	// This will build our "base URL" ... Also accounts for HTTPS :)
	$base = ($secure_connection ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

	// Initialize a temporary array with our breadcrumbs. (starting with our home page, which I'm assuming will be the base URL)
	$breadcrumbs = Array("<a href=\"$base\">$home</a>");

	// Find out the index for the last value in our path array
	$last = end(array_keys($path));

	// Build the rest of the breadcrumbs
	foreach ($path AS $x => $crumb) {
		// Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
		$title = ucwords(str_replace(Array('.php', '_'), Array('', ' '), $crumb));

		// If we are not on the last index, then display an <a> tag
		if ($x != $last)
			$breadcrumbs[] = "<a href=\"$base$crumb\">$title</a>";
		// Otherwise, just display the title (minus)
		else
			$breadcrumbs[] = $title;
	}

	// Build our temporary array (pieces of bread) into one big string :)
	echo "<div class='breadcrumbs'>";
	echo implode($separator, $breadcrumbs);
	echo "</div>";
}

// check if debug mode is allowed
function CanDebug() {
	global $DEBUG;
	$allowed = array ('127.0.0.1', '74.137.12.48');
	if (in_array ($_SERVER['REMOTE_ADDR'], $allowed)) return $DEBUG;
	else return 0;
}

// insert a debug message in the DOM
function Debug ($message) {
	if (!CanDebug()) return;
	echo '<div style="background:yellow; color:black; border: 1px solid black;';
	echo 'padding: 5px; margin: 5px; white-space: pre;">';
	if (is_string ($message)) echo $message;
	else var_dump ($message);
	echo '</div>';
}
?>