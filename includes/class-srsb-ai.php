<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

class SRSB_AI {

	public static function chat( $prompt ) {
		$api_key = get_option( 'simreact_ai_api_key' );

		if ( empty( $api_key ) ) {
			return new WP_Error( 'srsb_no_api_key', __( 'No OpenRouter API key is set.', 'simreact-site-builder' ) );
		}

		$body = array(
			'model' => 'google/gemini-2.5-flash',
			'messages' => array(
				array( 'role' => 'system', 'content' => 'You are a helpful assistant.' ),
				array( 'role' => 'user', 'content' => $prompt ),
			),
		);

		$response = wp_remote_post(
			'https://openrouter.ai/api/v1/chat/completions',
			array(
				'headers' => array(
					'Authorization' => 'Bearer ' . $api_key,
					'Content-Type'  => 'application/json',
				),
				'body'    => wp_json_encode( $body ),
				'timeout' => 30,
			)
		);

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		$content = $data['choices'][0]['message']['content'] ?? '';

		if ( empty( $content ) ) {
			return new WP_Error( 'srsb_ai_empty', __( 'AI returned no content.', 'simreact-site-builder' ) );
		}

		return $content;
	}

}
