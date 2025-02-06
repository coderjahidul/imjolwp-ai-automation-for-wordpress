<?php
class Settings_page {

    /**
	 * Display the settings page.
	 *
	 * @since 1.0.0
	 */
	public function display_settings_page() {
		?>
			<div class="wrap">
				<h1>ImjolWP AI Settings</h1>
				<form method="post" action="options.php">
					<?php
					settings_fields( 'imjolwp_ai_options_group' ); // Register settings group
					do_settings_sections( 'imjolwp-ai-settings' ); // Display settings sections
					submit_button();
					?>
				</form>
			</div>
    	<?php
	}
}