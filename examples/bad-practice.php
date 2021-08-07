<?php

/** 1 **/

$posts_query = new WP_Query( [
	'posts_per_page' => - 1,
	'post_type'      => 'post',
	'meta_query'     => [
		'relation' => 'AND',
		[
			'key'   => 'room_id',
			'value' => 100
		],
		[
			'key'     => 'room_menu',
			'compare' => 'EXISTS'
		]
	]
] );

$posts_menu_urls = [];

if ( $posts_query->have_posts() ) {

	while ( $posts_query->have_posts() ) {

		$posts_query->the_post();

		$post_id = get_the_ID();
		$post_menu_item = get_post_meta($post_id, 'post_menu', true);

		if($post_menu_item){
			$posts_menu_urls[] = get_the_permalink( $post_id );
		}


	}
}

wp_reset_postdata();

/* решение */
$posts = (new PostsQuery('posts'))->select(['post_name'])->join(
	['ID', 'post_id'], (new PostMetaQuery('meta'))->where([
		'meta_key' => 'room_id',
		'meta_value' => 100
	])
)->join(
	['ID', 'post_id'], (new PostMetaQuery('meta_menu'))->select([
		'menu_id' => 'meta_value',
		'meta_key' => 'post_menu'
	])
)->where(['post_status' => 'publish', 'post_type' => 'post'])->limit(-1)->get_results();

$urls = [];
foreach($posts as $post){
	$urls[] = get_home_url(null, $post->post_name);
}

/** 2 **/

$args = array(
	'post_type'              => array( 'casino_news' ),
	'post_status'            => array( 'publish' ),
	'posts_per_page'         => '-1',
	'meta_query' => array(
		'casino-id-turniry' => array(
			'key'     => 'casino-id-novosti',
			'value'   => get_the_ID(),
			'compare' => '=',
		),
	),
);

$get_arr_news = get_posts( $args );
if( count($get_arr_news) == 0 ) {
	$robots_meta_value = 'noindex, nofollow';
}

/* решение */
if((new PostsQuery())->where(['post_type' => 'casino_news', 'post_status' => 'publish'])->join(
	['ID', 'post_id'], (new PostMetaQuery())->where([
		'meta_key' => 'casino-id-novosti', 'meta_value' => get_the_ID()
	])
)->get_count()){
	$robots_meta_value = 'noindex, nofollow';
}

/** 3 **/

$args = array(
	'post_type'              => array( 'any_type' ),
	'post_status'            => array( 'publish' ),
	'posts_per_page'         => '-1',
);

$posts = get_posts( $args );

$a = 0;
foreach($posts as $post){
	$a++;
}

/* решение */
$cnt = (new PostsQuery())->where(['post_type' => 'any_type', 'post_status' => 'publish'])->get_count();