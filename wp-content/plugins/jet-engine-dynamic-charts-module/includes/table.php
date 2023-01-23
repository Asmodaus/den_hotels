<?php
namespace Jet_Engine_Dynamic_Charts;

use Jet_Engine\Query_Builder\Manager as Query_Builder;

class Chart {

	private $columns    = array();
	private $settings   = array();
	private $query      = null;

	public function __construct( $settings = array(), $columns = array() ) {

		$this->chart_id = $chart_id;
		$this->setup_chart( $settings, $columns );

	}

	public function setup_chart( $settings = array(), $columns = array() ) {

		if ( ! empty( $columns ) ) {
			foreach( $columns as $column ) {
				$this->columns[ $column['_id'] ] = $column;
			}
		}

		$this->settings = $settings;

		$query_id = ! empty( $this->settings['query_id'] ) ? $this->settings['query_id'] : false;

		if ( $query_id ) {
			$this->query = Query_Builder::instance()->get_query_by_id( $query_id );
		}

	}

	/**
	 * Returns query
	 *
	 * @return [type] [description]
	 */
	public function get_query() {
		return $this->query;
	}

	/**
	 * Returns an array of table rows
	 *
	 * @return [type] [description]
	 */
	public function get_data() {

		if ( ! $this->query ) {
			return array();
		}

		$items = $this->query->get_items();

	}

	public function get_raw_content( $column ) {

		$res = null;

		switch ( $column['data_source'] ) {
			case 'object':

				$prop = ! empty( $column['object_field'] ) ? $column['object_field'] : false;

				if ( $prop ) {
					$res = jet_engine()->listings->data->get_prop( $prop );
				}

				break;

			case 'meta':

				$key = ! empty( $column['meta_key'] ) ? $column['meta_key'] : false;

				if ( $key ) {
					$res = jet_engine()->listings->data->get_meta( $key );
				}

				break;

			case 'fetched':
				$object = jet_engine()->listings->data->get_current_object();
				$col    = ! empty( $column['fetched_column'] ) ? $column['fetched_column'] : false;
				$res    = isset( $object->$col ) ? $object->$col : false;
				break;
		}

		if ( ! empty( $column['apply_callback'] ) && ! empty( $column['filter_callback'] ) ) {
			$res = jet_engine()->listings->apply_callback( $res, $column['filter_callback'], $column );
		}

		if ( ! empty( $column['customize'] ) && ! empty( $column['customize_format'] ) ) {
			$res = sprintf( $column['customize_format'], $res );
		}

		return do_shortcode( wp_unslash( $res ) );

	}

}
