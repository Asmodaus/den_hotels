<?php
/**
 * \dimadin\WP\Library\Backdrop\Server class.
 *
 * @package Backdrop
 * @since 1.0.0
 */

namespace dimadin\WP\Library\Backdrop;

use WP_Temporary;
use WP_Error;

/**
 * Class that executes Backdrop tasks.
 *
 * @since 1.0.0
 */
class Server {
	/**
	 * Run task.
	 *
	 * @since 1.0.0
	 *
	 * @return bool|WP_Error True on success, WP_Error on failure.
	 */
	public function run() {
		$key = isset( $_POST['key'] ) ? sanitize_text_field( wp_unslash( $_POST['key'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.NoNonceVerification

		if ( empty( $key ) ) {
			return new WP_Error( 'md_backdrop_no_key', 'No key supplied' );
		}

		$data = WP_Temporary::get( 'md_backdrop-' . $key );
		if ( ! is_array( $data ) || ! array_key_exists( 'callback', $data ) || ! array_key_exists( 'params', $data ) ) {
			return new WP_Error( 'md_backdrop_invalid_key', 'Supplied key was not valid' );
		}

		$result = call_user_func_array( $data['callback'], $data['params'] );
		WP_Temporary::delete( 'md_backdrop-' . $key );

		if ( is_wp_error( $result ) ) {
			return $result;
		}

		return true;
	}

	/**
	 * Trigger method that listens to task request.
	 *
	 * @since 1.0.0
	 */
	public static function spawn() {
		$server = new static();
		$server->run();
		exit;
	}
}
