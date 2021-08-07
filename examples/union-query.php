<?php

$results = (new DBUnion([
	(new PostsQuery())->select(['ID', 'post_author'])->where([
		'post_author__in' => [100,101,102,103]
	])->limit(10),
	(new PostsQuery())->select(['ID', 'post_author'])->join(
		['ID', 'post_id'], (new PostMetaQuery())->where(['meta_key' => 'rating', 'meta_value__from' => 4])
	)->limit(5)
]))->get_results();
