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
     * @param string $api_url The AI API URL.
     * @param string $api_key The API Key.
     * @param array $additional_payload Additional payload to include in the request.
     *
     * @return mixed The response from the API or false on failure.
     */
    public function make_request($endpoint, $api_url, $api_key, $additional_payload) {
            
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
            CURLOPT_POSTFIELDS => json_encode($additional_payload),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $api_key,
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function make_image_generate_request($endpoint, $api_url, $api_key, $additional_payload, $model){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $api_url . '/v1/' . $endpoint . '/' . $model,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($additional_payload),
            CURLOPT_HTTPHEADER => array(
              'Content-Type: application/json',
              'Authorization: Bearer ' . $api_key,
            ),
          ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
