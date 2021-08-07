<?php

/* insert */
( new PostsQuery() )->insert( [
	'post_title'   => 'Post title',
	'post_content' => 'Post content',
	'post_author'  => 1
] );

/* update */
( new PostsQuery() )->where( [
	'post_status__in' => [ 'draft', 'pending' ],
	'post_author'     => 1
] )->update( [
	'post_status' => 'publish'
] );

/* delete */
( new PostsQuery() )->where( [
	'post_status'     => 'draft',
	'post_author__in' => [ 10, 11, 12 ]
] )->delete();
