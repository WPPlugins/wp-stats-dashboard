<?php
/**
 * WPSDPostViewsDashboardWidget.
 * @author dligthart <info@daveligthart.com>
 * @version 0.2
 * @package wp-stats-dashboard
 */
class WPSDPostViewsDashboardWidget{

	/**
	 * Constructor.
	 * @access public
	 */
	function WPSDPostViewsDashboardWidget() {
		add_action( 'wp_dashboard_setup', array(&$this, 'register_widget') );
		add_filter( 'wp_dashboard_widgets', array(&$this, 'add_widget') );
	}

	/**
	 * Register widget.
	 * @access protected
	 */
	function register_widget() {
		wp_register_sidebar_widget('wpsd_postviews', 'Stats - Post views',
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

		if ( !isset($wp_registered_widgets['wpsd_postviews']) ) return $widgets;

		array_splice( $widgets, 2, 0,'wpsd_postviews');

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

		echo '<!-- WP-Stats-Dashboard - START Post views -->';
		// Parse posts views.
		$pattern = '<div id="postviews".*?>(.*?)<\/div>';
		preg_match_all('/'.$pattern.'/s', $result, $matches);

		$pv = preg_replace('/<h4>(.*?)<\/h4>/s', '<h5>$1</h5>', $matches[1][0]);
		$pv = preg_replace('/<h3>(.*?)<\/h3>/s', '<h4>Post views</h4>', $pv);

		echo $pv;
		echo '<!-- WP-Stats-Dashboard - STOP Post views-->';

		ob_end_flush();

		echo $after_widget;
	}
}
?>