<?php
/**
 * WPSDClicksDashboardWidget.
 * @author dligthart <info@daveligthart.com>
 * @version 0.2
 * @package wp-stats-dashboard
 */
class WPSDClicksDashboardWidget{

	/**
	 * Constructor.
	 * @access public
	 */
	function WPSDClicksDashboardWidget() {
		add_action( 'wp_dashboard_setup', array(&$this, 'register_widget') );
		add_filter( 'wp_dashboard_widgets', array(&$this, 'add_widget') );
	}

	/**
	 * Register widget.
	 * @access protected
	 */
	function register_widget() {
		wp_register_sidebar_widget('wpsd_clicks', 'Stats - Clicks',
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

		if ( !isset($wp_registered_widgets['wpsd_clicks']) ) return $widgets;

		array_splice( $widgets, 2, 0,'wpsd_clicks');

		return $widgets;
	}

	/**
	 * Widget.
	 */
	function widget($args = array()) {
		if (is_array($args))
			extract( $args, EXTR_SKIP );

		echo $before_widget.$before_title.$widget_name.$after_title;

		ob_start();

		$result =  wpsd_read_cache();

		echo '<!-- WP-Stats-Dashboard - START Clicks -->';
		// Parse Clicks.
		$pattern = '<div id="clicks".*?>(.*?)<\/div>';
		preg_match_all('/'.$pattern.'/s', $result, $matches);

		$clicks = preg_replace('/<h4>(.*?)<\/h4>/s', '<h5>$1</h5>', $matches[1][0]);
		$clicks = preg_replace('/<h3>(.*?)<\/h3>/s', '<h4>Clicks</h4>', $clicks);

		echo $clicks;
		echo '<!-- WP-Stats-Dashboard - STOP Clicks -->';

		ob_end_flush();

		echo $after_widget;
	}
}
?>