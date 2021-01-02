<?php

$post_ids = DBQuery::tbl(new Posts_Query())->select([
		'ID'
	])->where([
		'post_type' => 'post',
		'comment_count__not_in' => [0]
	])
	->limit(5)
	->orderby('post_date')
	->get_col();


$results = DBQuery::tbl(new Posts_Query())->select([
		'ID', 'post_content', 'post_author'
	])->where([
		'post_type__in' => ['post', 'page'],
		'post_status__not_in' => ['trash', 'pending']
	])
	->limit(10, 20) //number 10, offset 20
	->orderby('ID', 'ASC')
	->get_results('cache');


$user_ids = DBQuery::tbl(new Users_Query())->select([
		'ID'
	])->join(
		['ID', 'post_author'],
		DBQuery::tbl(new Posts_Query())->where([
			'post_type' => 'post',
			'post_status' => 'publish'
		])
	)
	->limit(-1) //all results
	->orderby('user_registered')
	->get_col('cache');


$cnt_users = DBQuery::tbl(new Users_Query())->join(
		['ID', 'user_id'],
		DBQuery::tbl(new User_Meta_Query())->where([
			'meta_key' => 'user_rating',
			'meta_value__between' => [2, 5]
		])
	)
	->get_count();
