<?php
namespace Imjolwp\Includes\Automation;
class AI_Post_Creator {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_post_generate_ai_post', array($this, 'generate_ai_post'));
    }

    public function add_admin_menu() {
        add_menu_page(
            'AI Post Creator', 
            'AI Post Creator', 
            'manage_options', 
            'ai-post-creator', 
            array($this, 'admin_page'), 
            'dashicons-edit'
        );
    }

    public function admin_page() {
        ?>
        <div class="wrap">
            <h2>AI Post Creator</h2>
            <form method="post" action="admin-post.php">
                <input type="hidden" name="action" value="generate_ai_post">
                <?php wp_nonce_field('generate_ai_post_nonce', 'ai_post_nonce'); ?>
                <label>Post Title:</label>
                <input type="text" name="post_title" required><br><br>
                <label>Related Words:</label>
                <input type="text" name="related_words"><br><br>
                <label>Minimum Word Count:</label>
                <input type="number" name="min_words" required><br><br>
                <label>Language:</label>
                <select name="language">
                    <option value="en">English</option>
                    <option value="es">Spanish</option>
                </select><br><br>
                <input type="submit" value="Generate Post" class="button button-primary">
            </form>
        </div>
        <?php
    }

    public function generate_ai_post() {
        if (!isset($_POST['ai_post_nonce']) || !wp_verify_nonce($_POST['ai_post_nonce'], 'generate_ai_post_nonce')) {
            wp_die('Security check failed');
        }

        $post_title = sanitize_text_field($_POST['post_title']);
        $related_words = sanitize_text_field($_POST['related_words']);
        $min_words = intval($_POST['min_words']);
        $language = sanitize_text_field($_POST['language']);

        // Call AI API (Replace with actual API integration)
        $generated_content = "This is a placeholder for AI-generated content.";

        // Insert post into WordPress
        $post_data = array(
            'post_title'   => $post_title,
            'post_content' => $generated_content,
            'post_status'  => 'draft',
            'post_type'    => 'post'
        );
        wp_insert_post($post_data);

        wp_redirect(admin_url('admin.php?page=ai-post-creator&success=1'));
        exit;
    }
}

// new AI_Post_Creator();