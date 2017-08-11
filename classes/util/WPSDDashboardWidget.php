<?php
/**
 * WPSDDashboardWidget.
 * @author dligthart <info@daveligthart.com>
 * @version 0.2
 * @package wp-stats-dashboard
 */
class WPSDDashboardWidget extends WPSDWPPlugin {

	/**
	 * Constructor.
	 */
	function WPSDDashboardWidget() {
		global $wp_version;

		$this->plugin_name = 'wp-stats-dashboard';
		$this->plugin_base = dirname(__FILE__) . '/../..';

		if($wp_version >= 2.7) {
			add_action( 'wp_dashboard_setup', array(&$this, 'register_widget') );
			add_filter( 'wp_dashboard_widgets', array(&$this, 'add_widget') );
		}
	}
	/**
	 * Register widget.
	 * @access protected
	 */
	function register_widget() {
		wp_register_sidebar_widget('wpstatsdashboard_widget', 'Stats - Views per day',
			array(&$this, 'widget'),
			array(
			'all_link' => 'http://www.daveligthart.com',
			'feed_link' => '',
			'edit_link' => 'options.php' )
		);
	}
	/**
	 * Add widget.
	 * @param array $widgets
	 * @access protected
	 */
	function add_widget( $widgets ) {
		global $wp_registered_widgets;
		if ( !isset($wp_registered_widgets['wpstatsdashboard_widget']) ) return $widgets;
		array_splice( $widgets, 2, 0, 'wpstatsdashboard_widget' );
		return $widgets;
	}
	/**
	 * Widget.
	 */
	function widget($args = array()) {
		if (is_array($args))
			extract( $args, EXTR_SKIP );

		echo $before_widget.$before_title.$widget_name.$after_title;

		$this->render_admin('admin_dashboard', array('plugin_name'=>'wp-stats-dashboard'));

		echo $after_widget;
	}
}
?>