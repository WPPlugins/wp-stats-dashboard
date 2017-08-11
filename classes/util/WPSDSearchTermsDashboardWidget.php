<?php
/**
 * WPSDSearchTermsDashboardWidget.
 * @author dligthart <info@daveligthart.com>
 * @version 0.2
 * @package wp-stats-dashboard
 */
class WPSDSearchTermsDashboardWidget{

	/**
	 * Constructor.
	 * @access public
	 */
	function WPSDSearchTermsDashboardWidget() {
		add_action( 'wp_dashboard_setup', array(&$this, 'register_widget') );
		add_filter( 'wp_dashboard_widgets', array(&$this, 'add_widget') );
	}

	/**
	 * Register widget.
	 * @access protected
	 */
	function register_widget() {
		wp_register_sidebar_widget('wpsd_searchterms', 'Stats - Search terms',
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

		if ( !isset($wp_registered_widgets['wpsd_searchterms']) ) return $widgets;

		array_splice( $widgets, 2, 0,'wpsd_searchterms');

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

		'<!-- WP-Stats-Dashboard - START Search terms-->';
		// Parse Search Terms.
		$pattern = '<div id="searchterms".*?>(.*?)<\/div>';
		preg_match_all('/'.$pattern.'/s', $result, $matches);

		$st = preg_replace('/<h4>(.*?)<\/h4>/s', '<h5>$1</h5>', $matches[1][0]);
		$st = preg_replace('/<h3>(.*?)<\/h3>/s', '<h4>Search Terms</h4>', $st);

		echo $st;
		echo '<!-- WP-Stats-Dashboard - STOP Search terms -->';

		ob_end_flush();

		echo $after_widget;
	}
}
?>