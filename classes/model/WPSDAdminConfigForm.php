<?php
/**
 * WPSDAdminConfigForm model object.
 * @author Dave Ligthart <info@daveligthart.com>
 * @version 0.1
 * @package wp-stats-dashboard
 */
include_once('WPSDBaseForm.php');
class WPSDAdminConfigForm extends WPSDBaseForm{
	var $wpsd_blog_id;
	var $wpsd_un;
	var $wpsd_pw;
	var $wpsd_type; //chart type.

	function WPSDAdminConfigForm(){
		parent::WPSDBaseForm();
		if($this->setFormValues()){

			$this->saveOptions();
		}
		$this->loadOptions();

		if($this->wpsd_blog_id == '') {
			$options = get_option('stats_options'); // from wp-stats.
			$temp = $options['blog_id'];
			$this->wpsd_blog_id = $temp;
		}
	}

	function getWpsdBlogId(){
		return $this->wpsd_blog_id;
	}

	function getWpsdUn(){
		return $this->wpsd_un;
	}

	function getWpsdPw(){
		return $this->wpsd_pw;
	}

	function getWpsdType() {
		return $this->wpsd_type;
	}
}
?>