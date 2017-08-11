<?php
/**
 * Components.
 * @author Dave Ligthart <info@daveligthart.com>
 * @version 0.1
 * @package wp-stats-dashboard
 */

/**
 * Create HTML-code for a dropdown
 * containing a number of options.
 *
 * @param $name   string  The name of the select field.
 * @param $values hash    The values for the options by their names
 *                        eg. $values["value-1"] = "option label 1";
 * @param $selected  string The value of the selected option.
 * $attr Optional attributes (eg. onChange stuff)
 *
 * @return string The HTML code for a option construction.
 */
function wpsd_html_dropdown($name, $values, $selected = "", $attr = ""){
	foreach($values as $key => $value) {
        $options .= "\t<option ".(($key == $selected) ? "selected=\"selected\"" : "")." value=\"".$key."\">".$value."&nbsp;&nbsp;</option>\n";
    }
	return "<select name=\"".$name."\"  id=\"".$name."\" $attr>\n".$options."</select>\n";
}

/**
 * Get script url.
 * @return url
 * @access public
 */
function wpsd_get_settings_url() {
	$url = get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=wp-stats-dashboard';
	return $url;
}
/**
 * Write cache.
 * @param string $output output to cache
 * @access public
 */
function wpsd_write_cache($output = '') {
	$filename = WPSD_CACHE_PATH  . 'wpsd_cache';

	if(!file_exists($filename)) {
		//echo ' CREATE NEW CACHE';
	}

	touch($filename);

	$f = fopen($filename, 'w' );
	fwrite($f, $output);
	fclose($f);
	//echo ' WRITE CACHE';
}
/**
 * Read cache.
 * @return cache results
 */
function wpsd_read_cache() {
	$filename = WPSD_CACHE_PATH  . 'wpsd_cache';

	$expire_seconds = 600;

	$contents = '';

	//echo ' ' . (time() - filemtime($filename));

	// Clear cache.
	if(file_exists($filename) && (time() - filemtime($filename)) >= $expire_seconds ){
		wpsd_clear_cache();
		$contents = wpsd_retrieve_stats(); // get new results.
	} // Read cache.
	elseif(file_exists($filename)) {

		if(filesize($filename) > 0) {
			$handle = fopen($filename, 'r');
			$contents = fread($handle, filesize($filename));
			fclose($handle);
			//echo ' READ CACHE';
		} else {
			$contents = wpsd_retrieve_stats();
		}

	} // Create new cache.
	else {
		$contents = wpsd_retrieve_stats();
	}
	return $contents;
}

/**
 * Clear cache.
 */
function wpsd_clear_cache() {
	wpsd_write_cache();
	//echo ' CLEAR CACHE';
}

/**
 * Retrieve dashboard stats.
 * @return result
 * @access public
 */
function wpsd_retrieve_stats() {
	$blog_id = get_option('wpsd_blog_id');
	$cookie_filename = md5($blog_id);

	$form = new WPSDAdminConfigForm();
	$un =urlencode($form->getWpsdUn());
	$pw = $form->getWpsdPw();

	$cache_path = WPSD_CACHE_PATH;
	$cache_dir = $cache_path . 'wp-stats-dashboard';

	$url = 'https://dashboard.wordpress.com/wp-login.php?redirect_to=wp-admin/index.php?page=stats';
	$postdata="log={$un}&pwd={$pw}&&wp-submit=Log In";
	$cookie = $cache_dir . '/' . $cookie_filename;

	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
	curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_COOKIEJAR, $cookie);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $cookie);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt ($ch, CURLOPT_POST, 1);
	$result = curl_exec ($ch);
	curl_close($ch);

	wpsd_write_cache($result);

	return $result;
}
?>