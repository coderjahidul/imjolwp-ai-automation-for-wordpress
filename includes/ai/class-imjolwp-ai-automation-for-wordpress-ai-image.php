<?php

class Imjolwp_Ai_Automation_For_Wordpress_Ai_Image {

    /**
     * Generates an AI-based image URL from the post title.
     *
     * @param string $title The post title.
     * @return string|null The generated image URL or null on failure.
     */
    public function generate_image( $title ) {
        // Example AI API URL (Replace with your actual AI image API)
        $api_url = get_option( 'imjolwp_ai_api_url' );
        $api_key = get_option( 'imjolwp_ai_api_key' );
        $model = 'meta-llama/Llama-3.3-70B-Instruct';
        $endpoint = 'openai/chat/completions';

        // Prepare the data to send in the request
        $data = [
            'text' => $title
        ];

        // Instantiate the AI cURL class and make the request
        $curl = new Imjolwp_Ai_Automation_For_Wordpress_Ai_Curl();
        $response = $curl->make_request( $endpoint, $model, $data, $api_url, $api_key );

        // Check for errors
        if ( is_wp_error( $response ) ) {
            return null;
        }

        // Parse response
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );

        return $data['image_url'] ?? null;
    }
}
