<?php

class DBUnion {

	private $queries = [];
	public $is_union = true;

	function __construct( $queries ) {
		$this->queries = $queries;
	}

	function select( $args ) {

		foreach ( $this->queries as $k => $query ) {
			$this->queries[ $k ]->select( $args );
		}

		return $this->queries;

	}

	function join( $args, $joinQuery ) {

		foreach ( $this->queries as $k => $query ) {
			$this->queries[ $k ]->join( $args, clone $joinQuery );
		}

		return $this;

	}

	function get_var( $cache = false ) {
		return $this->get_data( 'get_var', $cache );
	}

	function get_results( $cache = false ) {
		return $this->get_data( 'get_results', $cache );
	}

	function get_row( $cache = false ) {
		return $this->get_data( 'get_row', $cache );
	}

	function get_col( $cache = false ) {
		return $this->get_data( 'get_col', $cache );
	}

	function get_count( $field_name = false, $cache = false ) {
		return ( ! $result = $this->get_operator_data( 'COUNT', $field_name, $cache ) ) ? 0 : $result;
	}

	function get_sum( $field_name = false, $cache = false ) {
		return ( ! $result = $this->get_operator_data( 'SUM', $field_name, $cache ) ) ? 0 : $result;
	}

	function get_max( $field_name = false, $cache = false ) {
		return $this->get_operator_data( 'MAX', $field_name, $cache );
	}

	function get_min( $field_name = false, $cache = false ) {
		return $this->get_operator_data( 'MIN', $field_name, $cache );
	}

	private function get_operator_data( $operator, $field_name = false ) {
		global $wpdb;

		if ( ! $this->queries ) {
			return false;
		}

		$sql     = array();
		$groupby = false;

		foreach ( $this->queries as $unionQuery ) {

			if ( isset( $unionQuery->query['groupby'] ) && $unionQuery->query['groupby'] ) {
				$groupby = true;
			}

			$sql[] = $unionQuery->get_sql( array(
				'select'  => array( $operator . '(' . $unionQuery->table['as'] . '.' . $field_name . ') AS total' ),
				'join'    => $unionQuery->query['join'],
				'where'   => $unionQuery->query['where'],
				'groupby' => $unionQuery->query['groupby']
			) );
		}

		$sql = array( 'SELECT SUM(total) FROM (' . implode( ' UNION ALL ', $sql ) . ') x' );

		if ( $groupby ) {
			$result = $wpdb->query( $sql );
		} else {
			$result = $wpdb->get_var( $sql );
		}

		return $result;
	}

	function get_sql() {

		if ( ! $this->queries ) {
			return false;
		}

		$sql = array();

		foreach ( $this->queries as $unionQuery ) {
			$sql[] = '(' . $unionQuery->get_sql() . ')';
		}

		$sql = implode( ' UNION ALL ', $sql );

		return $sql;
	}

	private function get_data( $method = 'get_results', $use_cache = false ) {
		global $wpdb;

		$sql = $this->get_sql();

		if ( $use_cache ) {
			$cachekey = md5( $sql );
			$cache    = wp_cache_get( $cachekey );
			if ( $cache !== false ) {
				return $cache;
			}
		}

		$data = $wpdb->$method( $sql );

		foreach ( $this->queries as $unionQuery ) {
			$data = $unionQuery->maybe_unserialize( $data );
		}

		$data = wp_unslash( $data );

		if ( $use_cache ) {
			wp_cache_add( $cachekey, $data );
		}

		return $data;
	}

}
