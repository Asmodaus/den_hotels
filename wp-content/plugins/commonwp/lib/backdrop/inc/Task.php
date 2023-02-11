<?php
/**
 * \dimadin\WP\Library\Backdrop\Task class.
 *
 * @package Backdrop
 * @since 1.0.0
 */

namespace dimadin\WP\Library\Backdrop;

use WP_Temporary;
use WP_Error;

/**
 * Class that schedules Backdrop tasks.
 *
 * @since 1.0.0
 */
class Task {
	/**
	 * Unique key based on task's callback and parameters.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	protected $key;

	/**
	 * Callback to execute when doing task.
	 *
	 * @since 1.0.0
	 * @var callable
	 */
	protected $callback;

	/**
	 * Parameters to pass to task's callback.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $params = array();

	/**
	 * Add new task.
	 *
	 * Any parameter after first is passed to callback.
	 *
	 * @since 1.0.0
	 *
	 * @param callable $callback Callback to execute when doing task.
	 *                           Should not be closure.
	 */
	public function __construct( $callback ) {
		$this->callback = $callback;

		if ( func_num_args() > 1 ) {
			$args = func_get_args();

			$this->params = array_slice( $args, 1 );
		}

		$this->key = $this->get_unique_id();
	}

	/**
	 * Schedule task to run.
	 *
	 * @since 1.0.0
	 *
	 * @return bool|WP_Error True on success, WP_Error if task is already scheduled.
	 */
	public function schedule() {
		if ( $this->is_scheduled() ) {
			return new WP_Error( 'md_backdrop_scheduled', 'Task is already scheduled to run' );
		}

		$data = array(
			'callback' => $this->callback,
			'params'   => $this->params,
		);
		WP_Temporary::set( 'md_backdrop-' . $this->key, $data, 5 * MINUTE_IN_SECONDS );
		add_action( 'shutdown', array( $this, 'spawn_server' ) );

		return true;
	}

	/**
	 * Check whether task is scheduled to run.
	 *
	 * @since 1.0.0
	 *
	 * @return bool Schedule status.
	 */
	public function is_scheduled() {
		return (bool) $this->get_data();
	}

	/**
	 * Cancel a previously scheduled task.
	 *
	 * @since 1.0.0
	 *
	 * @return bool|WP_Error True on success, WP_Error if task was not scheduled.
	 */
	public function cancel() {
		if ( ! $this->is_scheduled() ) {
			return new WP_Error( 'md_backdrop_not_scheduled', 'Task is not scheduled to run' );
		}

		WP_Temporary::delete( 'md_backdrop-' . $this->key );
		return true;
	}

	/**
	 * Spawn external request that runs task.
	 *
	 * @since 1.0.0
	 *
	 * @return bool Always returns true.
	 */
	public function spawn_server() {
		$server_url = admin_url( 'admin-ajax.php' );

		$data = array(
			'action' => 'md_backdrop_run',
			'key'    => $this->key,
		);
		$args = array(
			'body'      => $data,
			'timeout'   => 0.01,
			'blocking'  => false,
			'sslverify' => apply_filters( 'https_local_ssl_verify', false ),
		);
		wp_remote_post( $server_url, $args );
		return true;
	}

	/**
	 * Get task's callback and parameters.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed An array of callback and parameters on success, mixed otherwise.
	 */
	protected function get_data() {
		return WP_Temporary::get( 'md_backdrop-' . $this->key );
	}

	/**
	 * Get unique key from task's callback and parameters.
	 *
	 * @since 1.0.0
	 *
	 * @return string Key.
	 */
	protected function get_unique_id() {
		return sha1( serialize( $this->callback ) . serialize( $this->params ) ); // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.serialize_serialize
	}
}
