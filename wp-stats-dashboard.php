<?php
/*
Plugin Name: WP-Stats-Dashboard
Plugin URI: http://wordpress.org/extend/plugins/wp-stats-dashboard/
Description: Displays the WordPress.com Stats graph directly in your Dashboard. No more tiresomely opening the Blog Stats tab and manually logging in.
Version: 1.4.0
Author: Dave Ligthart
Author URI: http://www.daveligthart.com
*/

define('WPSD_CACHE_PATH', dirname(__FILE__) . '/../../cache/');

include_once(dirname(__FILE__) . '/classes/util/WPSDUtils.php');
include_once(dirname(__FILE__) . '/classes/model/WPSDAdminConfigForm.php');
include_once(dirname(__FILE__) . '/classes/util/WPSDWPPlugin.php');
include_once(dirname(__FILE__) . '/classes/action/WPSDAdminAction.php');
include_once(dirname(__FILE__) . '/classes/action/WPSDAdminConfigAction.php');
include_once(dirname(__FILE__) . '/classes/action/WPSDFrontEndAction.php');
include_once(dirname(__FILE__) . '/classes/util/com.daveligthart.php');
include_once(dirname(__FILE__) . '/classes/util/WPSDDashboardWidget.php');
include_once(dirname(__FILE__) . '/classes/util/WPSDOverviewDashboardWidget.php');
include_once(dirname(__FILE__) . '/classes/util/WPSDClicksDashboardWidget.php');
include_once(dirname(__FILE__) . '/classes/util/WPSDReferrersDashboardWidget.php');
include_once(dirname(__FILE__) . '/classes/util/WPSDPostViewsDashboardWidget.php');
include_once(dirname(__FILE__) . '/classes/util/WPSDSearchTermsDashboardWidget.php');

add_action('plugins_loaded', create_function('', '' .
		'global $wpsdClicksWidget; $wpsdClicksWidget = new WPSDClicksDashboardWidget();' .
		'global $wpStatsDashWidget; $wpStatsDashWidget = new WPSDDashboardWidget();' .
		'global $wpsdOverviewWidget; $wpsdOverviewWidget = new WPSDOverviewDashboardWidget();' .
		'global $wpsdRefWidget; $wpsdRefWidget = new WPSDReferrersDashboardWidget();' .
		'global $wpsdPostViewsWidget; $wpsdPostViewsWidget = new WPSDPostViewsDashboardWidget();' .
		'global $wpsdSearchTermsWidget; $wpsdSearchTermsWidget = new WPSDSearchTermsDashboardWidget();') );

/**
 * WP STATS dashboard main.
 * @author dligthart <info@daveligthart.com>
 * @version 1.4.0
 * @package wp-stats-dashboard
 */
class WPSDMain extends WPSDWPPlugin {

	/**
	 * @var AdminAction admin action handler
	 */
	var $adminAction = null;

	/**
	 * @var FrontEndAction frontend action handler
	 */
	var $frontEndAction = null;

	 /**
	  * __construct()
	  */
	function WPSDMain($path) {
		$this->register_plugin('wp-stats-dashboard', $path);
		if (is_admin()) {
			$this->adminAction = new WPSDAdminAction($this->plugin_name, $this->plugin_base);
		} else {
			$this->frontEndAction = new WPSDFrontEndAction($this->plugin_name, $this->plugin_base);
	 	}
	}
}

$wp_stats_dashboard = new WPSDMain(__FILE__);
?>