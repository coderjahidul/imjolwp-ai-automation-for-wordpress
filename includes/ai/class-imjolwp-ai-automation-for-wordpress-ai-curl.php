<?php

/**
 * Handles cURL requests for AI-related tasks.
 *
 * @since 1.0.0
 */
class Imjolwp_Ai_Automation_For_Wordpress_Ai_Curl {

    /**
     * Make a cURL request to the AI API with given endpoint and parameters.
     *
     * @param string $endpoint The API endpoint.
     * @param array $data The data to send to the API.
     * @param string $api_url The AI API URL.
     * @param string $api_key The API Key.
     * @param string $model The requested model to use.
     *
     * @return mixed The response from the API or false on failure.
     */
    public function make_request( $endpoint, $model, $data, $api_url, $api_key, $max_tokens = 1000 ) {
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $api_url . '/v1/' . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(array(
                'model' => $model,
                'messages' => array(
                    array(
                        'role' => 'user',
                        'content' => $data
                    )
                ),
                'max_tokens' => $max_tokens, // Limits the response to around 20 words (1 word ≈ 2-3 tokens)
                'temperature' => 0.7 // Adjust creativity level (0 = deterministic, 1 = highly random)

            )),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $api_key,
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        // Return the response
        return json_decode( $response, true );
    }
}
