<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/coderjahidul/
 * @since      1.0.0
 *
 * @package    Imjolwp_Ai_Automation_For_Wordpress
 * @subpackage Imjolwp_Ai_Automation_For_Wordpress/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Imjolwp_Ai_Automation_For_Wordpress
 * @subpackage Imjolwp_Ai_Automation_For_Wordpress/admin
 * @author     Jahidul islam Sabuz <sobuz0349@gmail.com>
 */
class Imjolwp_Ai_Automation_For_Wordpress_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// Hook to add the admin menu
		add_action('admin_menu', array($this, 'add_admin_menu'));

		// Register settings and fields
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		// Hook to generate post description
		add_action( 'save_post', array( $this, 'generate_post_description' ), 10, 3 );

		// Hook to generate post excerpt
		// add_action( 'save_post', array( $this, 'generate_post_excerpt' ), 10, 3 );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Imjolwp_Ai_Automation_For_Wordpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Imjolwp_Ai_Automation_For_Wordpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/imjolwp-ai-automation-for-wordpress-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Imjolwp_Ai_Automation_For_Wordpress_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Imjolwp_Ai_Automation_For_Wordpress_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/imjolwp-ai-automation-for-wordpress-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add an admin menu for the plugin.
	 *
	 * @since 1.0.0
	 */
	public function add_admin_menu() {
		add_menu_page(
			'ImjolWP AI Automation',  // Page title
			'ImjolWP AI',             // Menu title
			'manage_options',         // Capability
			'imjolwp-ai-dashboard',   // Menu slug
			array($this, 'display_admin_page'), // Callback function
			'dashicons-art',          // Dashicon icon
			25                        // Position
		);

		add_submenu_page(
			'imjolwp-ai-dashboard',
			'Settings',
			'Settings',
			'manage_options',
			'imjolwp-ai-settings',
			array($this, 'display_settings_page')
		);
	}

	/**
	 * Register settings and add fields for API URL and API Key.
	 *
	 * @since 1.0.0
	 */
	public function register_settings() {
		// Register settings group and individual fields
		register_setting(
			'imjolwp_ai_options_group', // Options group
			'imjolwp_ai_api_url',       // Option name for API URL
			'sanitize_text_field'       // Sanitize callback for API URL
		);

		register_setting(
			'imjolwp_ai_options_group', // Options group
			'imjolwp_ai_api_key',       // Option name for API Key
			'sanitize_text_field'       // Sanitize callback for API Key
		);

		// Add the section to settings page
		add_settings_section(
			'imjolwp_ai_settings_section',  // Section ID
			'API Configuration',            // Section Title
			null,                           // Callback for description (null for no description)
			'imjolwp-ai-settings'           // Settings page slug
		);

		// Add fields to the section
		add_settings_field(
			'imjolwp_ai_api_url_field',     // Field ID
			'API URL',                      // Field label
			array( $this, 'display_api_url_field' ), // Callback function to display the field
			'imjolwp-ai-settings',          // Settings page slug
			'imjolwp_ai_settings_section'   // Section ID
		);

		add_settings_field(
			'imjolwp_ai_api_key_field',     // Field ID
			'API Key',                      // Field label
			array( $this, 'display_api_key_field' ), // Callback function to display the field
			'imjolwp-ai-settings',          // Settings page slug
			'imjolwp_ai_settings_section'   // Section ID
		);
	}

	/**
	 * Display the input field for API URL.
	 *
	 * @since 1.0.0
	 */
	public function display_api_url_field() {
		$api_url = get_option( 'imjolwp_ai_api_url' ); // Get the current saved API URL
		echo "<input type='text' name='imjolwp_ai_api_url' value='" . esc_attr( $api_url ) . "' class='regular-text' />";
	}

	/**
	 * Display the input field for API Key.
	 *
	 * @since 1.0.0
	 */
	public function display_api_key_field() {
		$api_key = get_option( 'imjolwp_ai_api_key' ); // Get the current saved API Key
		echo "<input type='password' name='imjolwp_ai_api_key' value='" . esc_attr( $api_key ) . "' class='regular-text' />";
	}


	/**
	 * Display the admin dashboard page.
	 *
	 * @since 1.0.0
	 */
	public function display_admin_page() {
		?>
		<div class="ai-content-generator-wrap">
			<h1><?php _e('Welcome to ImjolWP AI Automation', 'ai-content-generator'); ?></h1>
			<div class="ai-content-generator-container">
				<div class="ai-content-generator-section">
					<h2><?php _e('AI Features', 'ai-content-generator'); ?></h2>
					<div class="ai-features-grid">
						<?php
						$features = [
							'ai_post_title' => __('Post Title', 'ai-content-generator'),
							'ai_post_description' => __('Post Description', 'ai-content-generator'),
							'ai_post_image' => __('Post Image', 'ai-content-generator'),
							'ai_post_summary' => __('Post Summary', 'ai-content-generator'),
							'ai_post_audio' => __('Post Audio', 'ai-content-generator'),
							'ai_post_video' => __('Post Video', 'ai-content-generator'),
						];
	
						foreach ($features as $key => $label) {
							$enabled = get_option($key, '0'); // Default to disabled
							?>
							<div class="ai-feature-card">
								<h3><?php echo $label; ?></h3>
								<p><?php echo sprintf(__('Generate %s using AI.', 'ai-content-generator'), strtolower($label)); ?></p>
								<label class="switch">
									<input type="checkbox" data-feature="<?php echo esc_attr($key); ?>" <?php checked($enabled, '1'); ?> onchange="toggleFeature(this)">
									<span class="slider"></span>
								</label>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<script>
			function toggleFeature(el) {
				let feature = el.getAttribute("data-feature");
				let status = el.checked ? 1 : 0;
	
				let data = new FormData();
				data.append("action", "toggle_ai_feature");
				data.append("feature", feature);
				data.append("status", status);
				data.append("_ajax_nonce", "<?php echo wp_create_nonce('toggle_ai_feature_nonce'); ?>");
	
				fetch(ajaxurl, {
					method: "POST",
					body: data
				})
				.then(response => response.json())
				.then(res => {
					if (res.success) {
						console.log(`${feature} updated successfully`);
					} else {
						alert("Failed to update setting.");
						el.checked = !el.checked; // Revert if failed
					}
				})
				.catch(error => console.error("Error:", error));
			}
		</script>
		<?php
	}

	public function register_ajax_handler() {
		add_action('wp_ajax_toggle_ai_feature', [$this, 'toggle_ai_feature']);
	}

	public function toggle_ai_feature() {
		check_ajax_referer('toggle_ai_feature_nonce');

		if (!current_user_can('manage_options')) {
			wp_send_json_error(['message' => __('Permission denied.', 'ai-content-generator')]);
		}

		$feature = isset($_POST['feature']) ? sanitize_text_field($_POST['feature']) : '';
		$status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : '0';

		if (!empty($feature)) {
			update_option($feature, $status);
			wp_send_json_success(['message' => __('Setting updated.', 'ai-content-generator')]);
		} else {
			wp_send_json_error(['message' => __('Invalid feature.', 'ai-content-generator')]);
		}
	}


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

	// public function ai_features_permission(){
	// 	if(get_option('ai_post_description') == '1'){
			
	// 	}
		
	// }

	// Generate post description
	public function generate_post_description( $post_id, $post, $update ) {
        // Avoid auto-saves and revisions
        if ( wp_is_post_revision( $post_id ) || defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return;
        }

        // Ensure it's a post and not a different post type
        if ( $post->post_type !== 'post' ) {
            return;
        }

		// Prevent infinite loop by temporarily removing the hook
		remove_action( 'save_post', array( $this, 'generate_post_description' ), 10 );

        // Get the post title
        $post_title = get_the_title( $post_id );

        // If there's no title, do nothing
        if ( empty( $post_title ) ) {
            return;
        }
		// Load AI Description Generator Class
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/ai/class-imjolwp-ai-automation-for-wordpress-ai-description.php';
	
		// Instantiate the AI class
		$ai_description_generator = new Imjolwp_Ai_Automation_For_Wordpress_Ai_Description();
		
		// Generate AI-based description
		$generated_description = $ai_description_generator->generate_description( $post_title );

		// Load Ai Summary Generator Class
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/ai/class-imjolwp-ai-automation-for-wordpress-ai-summary.php';
	
		// Instantiate the AI class
		$ai_summary_generator = new Imjolwp_Ai_Automation_For_Wordpress_Ai_Excerpt();
		
		// Generate AI-based summary
		$generated_summary = $ai_summary_generator->generate_excerpt( $generated_description );

        // Update the post content only if it's empty
        if ( empty( $post->post_content ) ) {
            wp_update_post( array(
                'ID'           => $post_id,
                'post_content' => sanitize_text_field( $generated_description ),
				'post_excerpt' => sanitize_text_field( $generated_summary ),
            ) );
        }

		// Re-add the hook after updating
		add_action( 'save_post', array( $this, 'generate_post_description' ), 10, 3 );
    }

}
