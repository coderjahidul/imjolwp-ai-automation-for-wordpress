<?php
namespace Imjolwp\Admin\Partials;
use Imjolwp\Automation\Imjolwp_Ai_Automation_For_Wordpress_Automation;
use Imjolwp\Ai\Imjolwp_Ai_Automation_For_Wordpress_Ai_Description;

class Imjolwp_Ai_Automation_For_Wordpress_Admin_Display {

    public function display_settings_page() {
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline">AI Post Generator</h1>

            <form method="post" action="" class="ai-content-form">
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="post_title">Post Title</label></th>
                        <td><input type="text" id="post_title" name="post_title" class="regular-text" placeholder="Enter post title"></td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="related_words">Related Keywords</label></th>
                        <td><input type="text" id="related_words" name="related_words" class="regular-text" placeholder="Enter related keywords"></td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="min_word_count">Minimum Word Count</label></th>
                        <td><input type="number" id="min_word_count" name="min_word_count" class="small-text" value="500"></td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="language">Language</label></th>
                        <td>
                            <select id="language" name="language" class="regular-select">
                                <option value="en">English</option>
                                <option value="es">Spanish</option>
                                <option value="fr">French</option>
                                <option value="de">German</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="post_status">Post Status</label></th>
                        <td>
                            <select id="post_status" name="post_status" class="regular-select">
                                <option value="draft">Draft</option>
                                <option value="publish">Published</option>
                                <option value="pending">Pending Review</option>
                                <option value="private">Private</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="post_types">Post Type</label></th>
                        <td>
                            <select id="post_types" name="post_types" class="regular-select">
                            <?php
                                $post_types = get_post_types(['public' => true], 'objects');
                                foreach ($post_types as $post_type) {
                                    echo '<option value="' . esc_attr($post_type->name) . '">' . esc_html($post_type->labels->singular_name) . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="schedule_automation">Schedule Automation</label></th>
                        <td>
                            <input type="checkbox" id="schedule_automation" name="schedule_automation" value="1">
                            <label for="schedule_automation">Enable Scheduled Post Generation</label>
                            <br><br>
                            <label for="schedule_time">Select Time:</label>
                            <input type="datetime-local" id="schedule_time" name="schedule_time">
                        </td>
                    </tr>

                </table>

                <?php submit_button('Generate Content', 'primary', 'generate_content'); ?>
            </form>

            <?php
            // Handle form submission
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_title']) && !empty($_POST['post_title'])) {
                $title = sanitize_text_field($_POST['post_title']);
                $related_words = sanitize_text_field($_POST['related_words']);
                $word_count = intval($_POST['min_word_count']);
                $language = sanitize_text_field($_POST['language']);
                $post_status = sanitize_text_field($_POST['post_status']);
                $post_type = sanitize_text_field($_POST['post_types']);
                $schedule_automation = isset($_POST['schedule_automation']) ? true : false;
                $schedule_time = isset($_POST['schedule_time']) ? sanitize_text_field($_POST['schedule_time']) : '';
                $author_id = get_current_user_id();

                // Simulate AI Content Generation (Replace with AI API Call)
                // $generated_content = "This is an AI-generated post about '$title' using related words: $related_words.";
                $generated_content = new Imjolwp_Ai_Automation_For_Wordpress_Ai_Description();
                $generated_content = $generated_content->generate_description($title);

                if ($schedule_automation && !empty($schedule_time)) {
                    // Schedule the task - 6 hours from now
                    $timestamp = strtotime($schedule_time) - 6 * 60 * 60;
                    if ($timestamp) {
                        wp_schedule_single_event($timestamp, 'ai_content_generate_event', [$title, $generated_content, $post_status, $post_type, $author_id]);
                        echo '<div class="updated"><p>AI Content Generation Scheduled!</p></div>';
                    }
                } else {
                    // Save as Post immediately
                    $post_id = wp_insert_post([
                        'post_title'   => $title,
                        'post_content' => $generated_content,
                        'post_status'  => $post_status,
                        'post_type'    => $post_type,
                    ]);

                    if ($post_id) {
                        echo '<div class="updated"><p>AI Content Generated! <a href="' . get_edit_post_link($post_id) . '">Edit Post</a></p></div>';
                    } else {
                        echo '<div class="error"><p>Failed to generate content.</p></div>';
                    }
                }
            }
            ?>

        </div>

        <?php
    }
}
