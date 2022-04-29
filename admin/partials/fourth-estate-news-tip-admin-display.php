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
<div class="news-tip-settings">
	<header>
		<div class="logo-section">
			<div class="logo">
				News Tips Settings and Configuration
			</div>
		</div>
		<nav class="nav-section">
			<?php settings_section_nav(); ?>
		</nav>
	</header>
	<div id="wrap">
		<form method="post" action="options.php">
			<?php
				settings_fields( 'fourth-estate-news-tip-settings' );
				
				settings_section_panes();
				// var_dump( (array) $wp_settings_sections[ 'fourth-estate-news-tip-settings' ] ); exit;
				// do_settings_sections( 'fourth-estate-news-tip-settings' );
				submit_button();
			?>
		</form>
	</div>
</div>
