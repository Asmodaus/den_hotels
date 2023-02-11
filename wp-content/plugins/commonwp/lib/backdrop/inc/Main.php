<?php
/**
 * \dimadin\WP\Library\Backdrop\Main class.
 *
 * @package Backdrop
 * @since 1.0.0
 */

namespace dimadin\WP\Library\Backdrop;

/**
 * Class that registers Backdrop.
 *
 * @since 1.0.0
 */
class Main {
	/**
	 * Version of Backdrop.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * Hook Backdrop listener that runs task.
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		if ( ! has_action( 'wp_ajax_nopriv_md_backdrop_run', __NAMESPACE__ . '\Server::spawn' ) ) {
			add_action( 'wp_ajax_nopriv_md_backdrop_run', __NAMESPACE__ . '\Server::spawn' );
		}
	}
}
