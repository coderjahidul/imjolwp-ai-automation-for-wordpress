<?php
namespace Imjolwp\Ai;
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
     * @param string $model The requested model to use.
     * @param string $blog_prompt The blog prompt for the AI to process.
     * @param string $api_url The AI API URL.
     * @param string $api_key The API Key.
     * @param int $max_tokens The maximum number of tokens (default 1000).
     * @param float $temperature The randomness (default 0.7).
     * @param float $top_p Top-p sampling (default 0.9).
     * @param int $top_k Top-k sampling (default 0).
     * @param float $presence_penalty Presence penalty (default 0).
     * @param float $frequency_penalty Frequency penalty (default 0).
     * @param string $response_format The response format (default 'none').
     * @param int|null $seed Optional seed for randomness.
     *
     * @return mixed The response from the API or false on failure.
     */
    public function make_request($endpoint, $model, $blog_prompt, $api_url, $api_key, $max_tokens = 1000, $temperature = 0.7, $top_p = 0.9, $top_k = 0, $presence_penalty = 0, $frequency_penalty = 0, $response_format = 'none', $seed = null) {
            
        $curl = curl_init();

        $payload = array(
            'model' => $model,
            'messages' => array(
                array(
                    'role' => 'user',
                    'content' => $blog_prompt
                )
            ),
            'max_tokens' => $max_tokens,
            'temperature' => $temperature,
            'top_p' => $top_p,
            'top_k' => $top_k,
            'presence_penalty' => $presence_penalty,
            'frequency_penalty' => $frequency_penalty,
            'response_format' => $response_format !== 'none' ? $response_format : null
        );

        if (!is_null($seed)) {
            $payload['seed'] = $seed;
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => $api_url . '/v1/' . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $api_key,
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // put_program_logs($response);
        return $response;
    }
}
