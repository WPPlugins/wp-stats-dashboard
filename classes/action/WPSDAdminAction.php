<?php
/**
 * WPSDAdminAction.
 * @author Dave Ligthart <info@daveligthart.com>
 * @version 0.1
 * @package wp-stats-dashboard
 */
class WPSDAdminAction extends WPSDWPPlugin{


	function WPSDAdminAction($plugin_name, $plugin_base){
		global $wp_version;

		$this->plugin_name = $plugin_name;
		$this->plugin_base = $plugin_base;

		/**
		 * Handle wordpress actions.
		 */
		$this->add_action('activate_'.trim($_GET['plugin']) ,'activate'); //plugin activation.
		$this->add_action('admin_head'); // header rendering.
		$this->add_action('admin_menu'); // menu rendering.

		if($wp_version < 2.7) {
			$this->add_action('activity_box_end','admin_dashboard'); // add chart to dashboard.
		}
	}

	/**
	 * Render admin views.
	 * Called by admin_menu.
	 * @access private
	 */
	function renderView() {
		$sub = $this->getAction();
		$url = $this->getActionUrl();

		// Display submenu
		$this->render_admin('admin_submenu', array ('url' => $url, 'sub' => $sub));

		/**
		 * Show view.
		 */
		switch($sub){
			default:
			case 'main':
				$this->admin_start();
			break;
			case 'login':
				$this->admin_autologin();
			break;
		}
	}

	/**
	 * Activate plugin.
	 * @access private
	 */
	function activate() {

	}

	/**
	 * Render header.
	 * @access private
	 */
	function admin_head(){
		$this->render_admin('admin_head', array("plugin_name"=>$this->plugin_name));
	}


	/**
	 * Create menu entry for admin.
	 * @return	void
	 * @access private
	 */
	function admin_menu(){
		if (function_exists('add_options_page')) {
			add_options_page(__('WP-Stats-Dashboard', 'wpstatsdashboard'),
			 	__('WP-Stats-Dashboard', 'wpstatsdashboard'),
				 10,
			 	basename ($this->dir()),
			 	array (&$this, 'renderView')
			 );
		}
	}

	/**
	 * Display the configuration settings.
	 * @access protected
	 */
	function admin_start(){
		$adminConfigAction = new WPSDAdminConfigAction($this->plugin_name, $this->plugin_base);
		$adminConfigAction->render();
	}

	/**
	 * Display the help page.
	 * @return void
	 * @access private
	 */
	function admin_help(){
		$this->render_admin('admin_help', array("plugin_name"=>$this->plugin_name));
	}

	/**
	 * Display wp-stats chart in dashboard.
	 * @return void
	 * @access private
	 */
	function admin_dashboard() {
		$this->render_admin('admin_dashboard', array("plugin_name"=>$this->plugin_name));
	}

	/**
	 * Display autologin.
	 */
	function admin_autologin() {
		$configForm = new WPSDAdminConfigForm();
		$this->render_admin('admin_autologin', array("plugin_name"=>$this->plugin_name,'form'=>$configForm));
	}
}
?>