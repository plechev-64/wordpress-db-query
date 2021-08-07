<?php

/*
 * the possible attributes of the shortcode:
 * ID
 * ID__in
 * ID__not_in
 * post_type
 * post_type__in
 * post_type__not_in
 * post_status
 * post_status__in
 * post_status__not_in
 * post_author
 * post_author__in
 * post_author__not_in
 * post_title
 * post_title__in
 * post_title__not_in
 * post_title__like
 * post_name
 * post_name__in
 * post_name__not_in
 * post_name__like
 * comment_count
 * comment_count__in
 * comment_count__not_in
 * comment_count__from
 * comment_count__to
 * number
 * offset
 * */

add_shortcode('posts', 'get_posts_shortcode');
function get_posts_shortcode($atts){

	$results = (new PostsQuery())->parse($atts)->get_results();

	$content = '';
	foreach($results as $result){
		$content .= 'Generate a content by the result data';
	}

	return $results;

}
