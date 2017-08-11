<?php
/**
 * Admin config template.
 * @author dligthart <info@daveligthart.com>
 * @version 0.1
 * @package wp-stats-dashboard
 */
$cache_path = dirname(__FILE__) . '/../../../../cache/';
?>
<?php
// Security.
$user = wp_get_current_user();
if($user->caps['administrator']):
?>
<div class="wrap">
	<h2><?php _e('WP-Stats-Dashboard Options','wpstatsdashboard');?></h2>

	<p>
		<?php if(!function_exists('curl_init')): ?>

		<strong><?php _e('CURL extension not installed:','wpstatsdashboard'); ?></strong>
		&nbsp;<?php _e('you must have CURL extension enabled in your php configuration','wpstatsdashboard');?>.
		<br/>

		<?php endif; ?>

		<?php if(!file_exists($cache_path)): ?>

		<strong><?php _e('wp-content/cache does not exist:','wpstatsdashboard');?></strong>
		&nbsp;<?php _e('please make sure that the "wp-content/cache" directory is created','wpstatsdashboard');?>.
		<br/>

		<?php else: ?>

		<?php if(!is_writable($cache_path)): ?>

		<strong><?php _e('wp-content/cache is not writable:','wpstatsdashboard');?></strong>
		&nbsp;<?php _e('please make sure that the "wp-content/cache" directory is writable by webserver.','wpstatsdashboard');?>.
		<br/>

		<?php endif; ?>

		<?php endif; ?>
	</p>
	<?php if(file_exists($cache_path) && is_writable($cache_path)): ?>
	<br/>
	<form name="wpsd_config_form" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
		<?= $form->htmlFormId(); ?>
		<table class="form-table" cellspacing="2" cellpadding="5" width="100%">
				<tr>
					<th scope="row">
						<label for="wpsd_blog_id"><?php _e('Blog ID','wpstatsdashboard'); ?>:</label>
					</th>
					<td>
								<?php
								echo "<input type='text' size='60' ";
								echo "name='wpsd_blog_id' ";
								echo "id='wpsd_blog_id' ";
								echo "value='".$form->getWpsdBlogId()."'" .
										"/>\n";
								?><br/>
								<?php _e('Enter blog id','wpstatsdashboard'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="wpsd_un"><?php _e('Username','wpstatsdashboard'); ?>:</label>
					</th>
					<td>
								<?php
								echo "<input type='text' size='60' ";
								echo "name='wpsd_un' ";
								echo "id='wpsd_un' ";
								echo "value='".$form->getWpsdUn()."'" .
										"/>\n";
								?><br/>
								<?php _e('Enter username','wpstatsdashboard'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="wpsd_pw"><?php _e('Password','wpstatsdashboard'); ?>:</label>
					</th>
					<td>
								<?php
								echo "<input type='password' size='60' ";
								echo "name='wpsd_pw' ";
								echo "id='wpsd_pw' ";
								echo "value='".$form->getWpsdPw()."'" .
										"/>\n";
								?><br/>
								<?php _e('Enter password','wpstatsdashboard'); ?>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="wpsd_type"><?php _e('Type','wpstatsdashboard'); ?>:</label>
					</th>
					<td>

				<?php
				  /**
					* line
				    * column (default)
				    * stacked column
				    * floating column
				    * 3d column
				    * image column
				    * stacked 3d column
				    * parallel 3d column
				    * pie
				    * 3d pie
				    * image pie
				    * donut
				    * bar
				    * stacked bar
				    * floating bar
				    * area
				    * stacked area
				    * 3d area
				    * stacked 3d area
				    * candlestick
				    * scatter
				    * polar
				    * bubble
					*/
					echo wpsd_html_dropdown('wpsd_type', array('line', 'column', 'bar', '3d column', '3d area', 'bubble'), $form->getWpsdType());
					?>
					<br/>
					<?php _e('Select chart type','wpstatsdashboard'); ?>
					</td>
				</tr>
		</table>
		<p class="submit"><input type="submit" name="Submit" value="<?php _e('Save Changes','wpstatsdashboard'); ?>" />
		</p>
	</form>

	<?php endif; ?>

</div>

<?php if('' != $form->getWpsdUn() && '' != $form->getWpsdPw()
	&& file_exists($cache_path) && is_writable($cache_path)): ?>

<div id="wpsd_graph" align="center">
	<script language="JavaScript" type="text/javascript">
	<!--
	if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
		alert("This page requires AC_RunActiveContent.js.");
	} else {
		var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
		if(hasRightVersion) {
			AC_FL_RunContent(
				'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
				'width', '550',
				'height', '240',
				'scale', 'noscale',
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
	</script>
</div>
<?php endif; ?>

<?php else: ?>
<strong><?php _e('As a user you have insufficient rights to view this configuration. Please contact your administrator.','wpstatsdashboard');?></strong>
<?php endif; ?>

<?php include_once('blocks/footer.php'); ?>
