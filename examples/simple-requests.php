<?php
/**
 Methods changing the query
 * select
 * select_string
 * where
 * where_string
 * join
 * number
 * offset
 * limit
 * groupby
 * order
 * orderby
 * orderby_case
 * orderby_as_number
 * orderby_string
 * date
 * parse

 Methods getting results
 * get_var
 * get_col
 * get_row
 * get_results
 * get_count
 * get_sum
 * get_max
 * get_min

 Methods getting data
 * get_query
 * get_sql

 **/

//get col values
$post_ids = DBQuery::tbl(new PostsQuery())->select([
		'ID'
	])->where([
		'post_type' => 'post',
		'comment_count__not_in' => [0]
	])
	->limit(5) //by default (30); no limit (-1)
	->orderby('post_date')
	->get_col();


//get results with cache
$results = DBQuery::tbl(new PostsQuery())->select([
		'ID', 'post_content', 'post_author'
	])->where([
		'post_type__in' => ['post', 'page'],
		'post_status__not_in' => ['trash', 'pending']
	])
	->limit(10, 20) //number 10, offset 20
	->orderby('ID', 'ASC')
	->get_results('cache');


//join
$user_ids = DBQuery::tbl(new UsersQuery())->select([
		'ID'
	])->join(
		['ID', 'post_author'],
		DBQuery::tbl(new PostsQuery())->where([
			'post_type' => 'post',
			'post_status' => 'publish'
		])
	)
	->limit(-1) //all results
	->orderby('user_registered')
	->get_col('cache');


//count with join
$cnt_users = DBQuery::tbl(new UsersQuery())->join(
		['ID', 'user_id'],
		DBQuery::tbl(new UserMetaQuery())->where([
			'meta_key' => 'user_rating',
			'meta_value__between' => [2, 5]
		])
	)
	->get_count();


//subquery counter
$users = DBQuery::tbl(new UsersQuery('users'))->select([
	'display_name',
	'posts_counter' => DBQuery::tbl(new PostsQuery('posts'))->select([
		'count' => ['ID']
	])->where_string("users.ID=posts.post_author")
])->get_results();


//subquery condition
$users = DBQuery::tbl(new UsersQuery('users'))->where([
	'ID__in' => DBQuery::tbl(new PostsQuery('posts'))->select(['post_author'])->where([
		'post_status' => 'publish',
		'comment_count__from' => 10
	])
])->get_results();
