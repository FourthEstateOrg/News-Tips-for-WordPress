<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.fourthestate.org/
 * @since      1.0.0
 *
 * @package    Fourth_Estate_News_Tip
 * @subpackage Fourth_Estate_News_Tip/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div id="wrap">
	<form method="post" action="options.php">
		<?php
			settings_fields( 'fourth-estate-news-tip-settings' );
			do_settings_sections( 'fourth-estate-news-tip-settings' );
			submit_button();
		?>
	</form>
</div>