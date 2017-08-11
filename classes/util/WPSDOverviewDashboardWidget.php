<?php
/**
 * WPSDOverviewDashboardWidget. General Stats.
 * @author dligthart <info@daveligthart.com>
 * @version 0.2
 * @package wp-stats-dashboard
 */
class WPSDOverviewDashboardWidget{

	/**
	 * Constructor.
	 * @access public
	 */
	function WPSDOverviewDashboardWidget() {
		add_action( 'wp_dashboard_setup', array(&$this, 'register_widget') );
		add_filter( 'wp_dashboard_widgets', array(&$this, 'add_widget') );
	}

	/**
	 * Register widget.
	 * @access protected
	 */
	function register_widget() {
		wp_register_sidebar_widget('wpsd_overview','Stats - Overview',
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

		if ( !isset($wp_registered_widgets['wpsd_overview']) ) return $widgets;

		array_splice( $widgets, 2, 0, 'wpsd_overview');

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

		echo '<!-- WP-Stats-Dashboard - START General Stats -->';
		// Parse General Stats
		$pattern = '<div id="generalblog".*?>(.*?)<\/div>';
		preg_match_all('/'.$pattern.'/s', $result, $matches);
		$generalStats = preg_replace('/<h3>(.*?)<\/h3>/s', '<h4>General Blog Stats</h4>', $matches[1][0]);
		echo $generalStats;
		echo '<!-- WP-Stats-Dashboard - STOP General Stats-->';

		ob_end_flush();

		echo $after_widget;
	}
}
?>