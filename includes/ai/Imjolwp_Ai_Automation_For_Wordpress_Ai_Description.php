<?php
namespace Imjolwp\Ai;
use Imjolwp\Ai\Imjolwp_Ai_Automation_For_Wordpress_Ai_Curl;
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

        // Instantiate the AI cURL class and make the request
        $curl = new Imjolwp_Ai_Automation_For_Wordpress_Ai_Curl();
        $response = $curl->make_request( $endpoint, $model, $title, $api_url, $api_key, $max_tokens );

        // $response = "This is post description";

        if ( is_wp_error( $response ) ) {
            // Handle error (optional)
            return 'Error generating description';
        }
        // response decode
        $response = json_decode( $response, true );
        // Get the generated description
        $content = $response['choices'][0]['message']['content'] ?? 'Content not found';
        // put_program_logs("Content: " . $content);

        // Return the generated description
        return ! empty( $content ) ? $content : 'Content not found';
    }
}
