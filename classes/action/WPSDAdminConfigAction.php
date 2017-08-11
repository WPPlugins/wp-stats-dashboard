<?php
/**
 * WPSDAdminConfigAction
 * @author Dave Ligthart <info@daveligthart.com>
 * @version 0.2
 * @package wp-stats-dashboard
 */
class WPSDAdminConfigAction extends WPSDWPPlugin{
	/**
	 * @var
	 */
	var $adminConfigForm = null;

	/**
	 * __construct()
	 */
	function WPSDAdminConfigAction($plugin_name, $plugin_base){
		$this->plugin_name = $plugin_name;
		$this->plugin_base = $plugin_base;
		$this->adminConfigForm = new WPSDAdminConfigForm();
	}

	/**
	 * Render form.
	 */
	function render(){
		$this->render_admin('admin_config', array(
				'form'=>$this->adminConfigForm,
				'plugin_base_url'=>$this->url(),
				'plugin_name'=>$this->plugin_name
			)
		);
	}
}