<?php

class PostsQuery extends DBQuery {
	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name' => $wpdb->posts,
			'as'   => $as ?: 'wp_posts',
			'cols' => array(
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
				'comment_count',
				'post_modified'
			)
		);

		parent::__construct( $table );
	}

}

class PostMetaQuery extends DBQuery {

	public $serialize = [ 'meta_value' ];

	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name' => $wpdb->postmeta,
			'as'   => $as ?: 'wp_postmeta',
			'cols' => array(
				'post_id',
				'meta_key',
				'meta_value'
			)
		);

		parent::__construct( $table );
	}

}

class CommentsQuery extends DBQuery {

	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name' => $wpdb->comments,
			'as'   => $as ?: 'wp_comments',
			'cols' => array(
				'comment_ID',
				'comment_post_ID',
				'comment_approved',
				'comment_date',
				'comment_author',
				'user_id'
			)
		);

		parent::__construct( $table );
	}

}

class CommentMetaQuery extends DBQuery {

	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name' => $wpdb->commentmeta,
			'as'   => $as ?: 'wp_commentmeta',
			'cols' => array(
				'meta_id',
				'comment_id',
				'meta_key',
				'meta_value'
			)
		);

		parent::__construct( $table );
	}

}

class UsersQuery extends DBQuery {

	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name' => $wpdb->users,
			'as'   => $as ?: 'wp_users',
			'cols' => array(
				'ID',
				'display_name',
				'user_nicename'
			)
		);

		parent::__construct( $table );
	}

}

class UserMetaQuery extends DBQuery {

	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name' => $wpdb->usermeta,
			'as'   => $as ?: 'wp_usermeta',
			'cols' => array(
				'umeta_id',
				'user_id',
				'meta_key',
				'meta_value'
			)
		);

		parent::__construct( $table );
	}

}

class TermsQuery extends DBQuery {
	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name' => $wpdb->terms,
			'as'   => $as ?: 'wp_terms',
			'cols' => array(
				'term_id',
				'name',
				'slug'
			)
		);

		parent::__construct( $table );
	}

}

class TermRelationshipsQuery extends DBQuery {
	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name' => $wpdb->term_relationships,
			'as'   => $as ?: 'wp_term_relationships',
			'cols' => array(
				'object_id',
				'term_taxonomy_id'
			)
		);

		parent::__construct( $table );
	}

}

class TermTaxonomyQuery extends DBQuery {
	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name' => $wpdb->term_taxonomy,
			'as'   => $as ?: 'wp_term_taxonomy',
			'cols' => array(
				'term_taxonomy_id',
				'term_id',
				'description',
				'taxonomy',
				'count',
			)
		);

		parent::__construct( $table );
	}

}

class TermMetaQuery extends DBQuery {
	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name' => $wpdb->termmeta,
			'as'   => $as ?: 'wp_termmeta',
			'cols' => array(
				'term_id',
				'meta_key',
				'meta_value',
			)
		);

		parent::__construct( $table );
	}

}

class OptionsQuery extends DBQuery {
	function __construct( $as = false ) {
		global $wpdb;

		$table = array(
			'name' => $wpdb->options,
			'as'   => $as ?: 'wp_options',
			'cols' => array(
				'option_id',
				'option_name',
				'option_value',
				'autoload'
			)
		);

		parent::__construct( $table );
	}

}
