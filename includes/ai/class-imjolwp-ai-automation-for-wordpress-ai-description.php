<?php

/**
 * Generates AI-powered description for posts.
 *
 * @since 1.0.0
 */
class Imjolwp_Ai_Automation_For_Wordpress_Ai_Description {

    /**
     * Generate AI-powered description for a post.
     *
     * @param string $title The title of the post.
     *
     * @return string The AI-generated description.
     */
    public function generate_description( $title ) {

        // Get the API URL and API Key from the plugin settings
        $api_url = get_option( 'imjolwp_ai_api_url' );
        $api_key = get_option( 'imjolwp_ai_api_key' );
        $model = 'meta-llama/Llama-3.3-70B-Instruct';
        $endpoint = 'openai/chat/completions';
        $max_tokens = 5000;

        // Prepare the data to send in the request
        $data = [
            'text' => $title
        ];
        // Load the AI cURL class file with the correct path
        require_once plugin_dir_path( __FILE__ ) . 'class-imjolwp-ai-automation-for-wordpress-ai-curl.php';

        // Instantiate the AI cURL class and make the request
        $curl = new Imjolwp_Ai_Automation_For_Wordpress_Ai_Curl();
        $response = $curl->make_request( $endpoint, $model, $data, $api_url, $api_key, $max_tokens );

        $response = "This is post description";

        if ( is_wp_error( $response ) ) {
            // Handle error (optional)
            return 'Error generating description';
        }

        // Return the generated description
        return ! empty( $response ) ? $response : 'Default Description';
    }
}
