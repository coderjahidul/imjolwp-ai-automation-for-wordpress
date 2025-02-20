<?php
/**
 * Summary of namespace Imjolwp\Admin\Settings
 */
namespace Imjolwp\Admin\Settings;
class Imjolwp_Ai_Automation_For_Wordpress_Dashboard {
    /**
	 * Display the admin dashboard page.
	 *
	 * @since 1.0.0
	 */
	public function display_dashboard_page() {
		?>
		<div class="ai-content-generator-wrap">
			<h1><?php _e('Welcome to ImjolWP AI Automation', 'ai-content-generator'); ?></h1>
			<div class="ai-content-generator-container">
				<div class="ai-content-generator-section">
					<h2><?php _e('AI Features', 'ai-content-generator'); ?></h2>
					<div class="ai-features-grid">
					<?php
					$features = [
						// 'ai_post_title' => __('Post Title', 'ai-content-generator'),
						'ai_post_description' => __('Post Description', 'ai-content-generator'),
						'ai_post_image' => __('Post Image', 'ai-content-generator'),
						// 'ai_post_excerpt' => __('Post Excerpt', 'ai-content-generator'),
						'ai_post_audio' => __('Post Audio', 'ai-content-generator'),
						'ai_post_video' => __('Post Video', 'ai-content-generator'),
					];

					$pro_features = ['ai_post_audio', 'ai_post_video']; // Features for Pro version

					foreach ($features as $key => $label) {
						$enabled = get_option($key, '0'); // Default to disabled
						?>
						<div class="ai-feature-card">
							<h3><?php echo $label; ?></h3>
							<p><?php echo sprintf(__('Generate %s using AI.', 'ai-content-generator'), strtolower($label)); ?></p>
							<?php if (in_array($key, $pro_features)) { ?>
								<span class="pro-badge"><?php _e('Pro Feature', 'ai-content-generator'); ?></span>
							<?php } else { ?>
								<label class="switch">
									<input type="checkbox" data-feature="<?php echo esc_attr($key); ?>" <?php checked($enabled, '1'); ?> onchange="toggleFeature(this)">
									<span class="slider"></span>
								</label>
							<?php } ?>
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
}