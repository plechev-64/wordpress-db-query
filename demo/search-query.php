<?php

//conditionals of search
$post_ids    = [ 10, 22, 35 ];
$post_status = [ 'publish' ];
$post_types  = [ 'post' ];

//$pagination
$page  = 2;
$number  = 10;
$offset = ( $page - 1 ) * $number;

$postsQuery = new Posts_Query();

if($post_ids){
	$postsQuery->where([
		'ID__in' => $post_ids
	]);
}

if($post_status){
	$postsQuery->where([
		'post_status__in' => $post_status
	]);
}

if($post_types){
	$postsQuery->where([
		'post_type__in' => $post_types
	]);
}

$postsQuery->limit($number, $offset);

//count results
$cnt_results = $postsQuery->get_count();

//get results
$results = $postsQuery->get_results();



