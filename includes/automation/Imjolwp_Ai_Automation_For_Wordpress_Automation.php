<?php 
namespace Imjolwp\Automation;

class Imjolwp_Ai_Automation_For_Wordpress_Automation {
    public function __construct() {
        add_action('ai_content_generate_event', [$this, 'generate_scheduled_content'], 10, 4);
    }

    public function generate_scheduled_content($title, $generated_content, $post_status, $post_type, $author_id) {
        // Save the AI-generated content as a post
        $post_id = wp_insert_post([
            'post_title'   => $title,
            'post_content' => $generated_content,
            'post_status'  => $post_status,
            'post_type'    => $post_type,
            'post_author'  => $author_id
        ]);

        if (is_wp_error($post_id)) {
            // Log error if post creation fails
            error_log('AI Content Generation Error: ' . $post_id->get_error_message());
        } else {
            // Log success
            error_log('AI Content Successfully Generated: Post ID ' . $post_id);

            // Optionally, send an email notification
            $admin_email = get_option('admin_email');
            $post_edit_link = get_edit_post_link($post_id);
            $message = "A new AI-generated post has been created.\n\nTitle: {$title}\n\nView/Edit: {$post_edit_link}";

            wp_mail($admin_email, 'New AI-Generated Post Created', $message);
        }
    }
}

