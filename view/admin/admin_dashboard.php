<?php
/**
 * Dashboard widget.
 * @author dligthart <info@daveligthart.com>
 * @version 0.2
 * @package wp-stats-dashboard
 */
global $wp_version;
$cache_path = dirname(__FILE__) . '/../../../../cache/';
$un = get_option('wpsd_un');
$pw = get_option('wpsd_pw');
$user = wp_get_current_user(); // stats are only for administrators.
?>
<?php if($user->caps['administrator'] && '' != $un && '' != $pw && file_exists($cache_path) && is_writable($cache_path)) : ?>
<p  align="left" id="wpsd_graph_widget" style="margin:0px;padding:20px 0px 0px 0px;">
	<script language="JavaScript" type="text/javascript">
	<!--
	if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
		alert("This page requires AC_RunActiveContent.js.");
	} else {
		var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
		if(hasRightVersion) {
			AC_FL_RunContent(
				'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
				<?php if($wp_version < 2.7): ?>
				'width', '550',
				'height', '240',
				'scale', 'noscale',
				<?php else: ?>
				'width', '100%',
				'height', '100%',
				'scale', 'default',
				<?php endif; ?>
				'salign', 'TL',
				'bgcolor', '#ffffff',
				'wmode', 'transparent',
				'movie', 'charts',
				'src', '<?php bloginfo('url');?>/wp-content/plugins/wp-stats-dashboard/resources/swf/charts',
				'FlashVars', 'library_path=../wp-content/plugins/wp-stats-dashboard/resources/swf/charts_library&xml_source=../wp-content/plugins/wp-stats-dashboard/view/admin/graph_xml.php',
				'id', 'my_chart',
				'name', 'my_chart',
				'menu', 'true',
				'allowFullScreen', 'true',
				'allowScriptAccess','never',
				'quality', 'high',
				'align', 'middle',
				'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
				'play', 'true',
				'devicefont', 'false'
				);
		} else {
			var alternateContent = 'This content requires the Adobe Flash Player. '
			+ '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
			document.write(alternateContent);
		}
	}
	// -->
	</script> 			            																															<p <?php if($wp_version < 2.7): ?>style="padding:5px 0px 5px 75px;"<?php endif; ?>>wp-stats-dashboard by:&nbsp;<a href="http://www.daveligthart.com" target="_blank" title="WP-Stats-Dashboard created By Dave Ligthart">daveligthart.com</a></p>
</p>
<?php else: ?>
<?php _e('check', 'wpstatsdashboard');?> <a href="<?php echo wpsd_get_settings_url(); ?>" title="wp-stats-dashboard settings" target="_self"><?php _e('settings', 'wpstatsdashboard'); ?></a>
<?php endif; ?>