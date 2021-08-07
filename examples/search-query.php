<?php

//conditionals of search
$searchData = [
	'ID__in' => [ 10, 22, 35 ],
	'post_status__in' => [ 'publish' ],
	'post_type__in' => [ 'post' ],
	'rating__from' => 4,
	'username' => 'vlad',
	'page' => 2,
	'number' => 10
];

$searchRules = [
	'ID__in' => function ( $query, $value ) {
		return $query->where( [ 'ID__in' => array_map('intval', $value ) ] );
	},
	'post_status__in' => function ( $query, $value ) {
		return $query->where( [ 'post_status__in' => array_map('strval', $value ) ] );
	},
	'post_type__in' => function ( $query, $value ) {
		return $query->where( [ 'post_type__in' => array_map('strval', $value ) ] );
	},
	'rating__from' => function ( $query, $value ) {
		return $query->join(
			['ID', 'post_id'], (new PostMetaQuery())->where([
				'meta_key' => 'rating',
				'meta_value__from' => intval($value)
			])
		);
	},
	'username' => function ( $query, $value ) {
		return $query->join([
			['post_author', 'ID'], (new UsersQuery())->where(['display_name__like' => strval($value)])
		]);
	},
];

$query = new PostsQuery();

foreach ( $searchRules as $key => $rule ) {
	if ( isset( $searchData[ $key ] ) && $searchData[ $key ] ) {
		$this->filters[ $key ] = $searchData[ $key ];
		$query                 = $rule( $query, $searchData[ $key ] );
	}
}

//count results
$total = $query->get_count();

//$pagination
if($searchData['page']){
	$offset = ( $searchData['page'] - 1 ) * $searchData['number'];
	$query->limit($searchData['number'], $offset);
}

//get results
$results = $query->get_results();