<?php

class Posts_Query extends DBQuery {
	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name'	 => $wpdb->posts,
			'as'	 => $as ? $as : 'wp_posts',
			'cols'	 => array(
				'ID',
				'post_author',
				'post_status',
				'post_type',
				'post_date',
				'post_title',
				'post_content',
				'post_parent',
				'post_name',
				'post_mime_type',
				'comment_count'
			)
		);

		parent::__construct( $table );
	}

}

class Post_Meta_Query extends DBQuery {

	public $serialize = ['meta_value'];

	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name'	 => $wpdb->postmeta,
			'as'	 => $as ? $as : 'wp_postmeta',
			'cols'	 => array(
				'post_id',
				'meta_key',
				'meta_value'
			)
		);

		parent::__construct( $table );
	}

}

class Terms_Query extends DBQuery {
	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name'	 => $wpdb->terms,
			'as'	 => $as ? $as : 'wp_terms',
			'cols'	 => array(
				'term_id',
				'name',
				'slug'
			)
		);

		parent::__construct( $table );
	}

}

class Term_Relationships_Query extends DBQuery {
	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name'	 => $wpdb->term_relationships,
			'as'	 => $as ? $as : 'wp_term_relationships',
			'cols'	 => array(
				'object_id',
				'term_taxonomy_id'
			)
		);

		parent::__construct( $table );
	}

}

class Term_Taxonomy_Query extends DBQuery {
	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name'	 => $wpdb->term_taxonomy,
			'as'	 => $as ? $as : 'wp_term_taxonomy',
			'cols'	 => array(
				'term_taxonomy_id',
				'term_id',
				'taxonomy',
				'count',
			)
		);

		parent::__construct( $table );
	}

}

class Term_Meta_Query extends DBQuery {
	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name'	 => $wpdb->termmeta,
			'as'	 => $as ? $as : 'wp_termmeta',
			'cols'	 => array(
				'term_id',
				'meta_key',
				'meta_value',
			)
		);

		parent::__construct( $table );
	}

}

class Users_Query extends DBQuery {
	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name'	 => $wpdb->users,
			'as'	 => $as ? $as : 'wp_users',
			'cols'	 => array(
				'ID',
				'user_login',
				'user_nicename',
				'user_email',
				'user_url',
				'user_registered',
				'user_nicename',
				'user_status',
				'display_name',
			)
		);

		parent::__construct( $table );
	}

}

class User_Meta_Query extends DBQuery {
	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name'	 => $wpdb->usermeta,
			'as'	 => $as ? $as : 'wp_usermeta',
			'cols'	 => array(
				'umeta_id',
				'meta_key',
				'meta_value'
			)
		);

		parent::__construct( $table );
	}

}
