<?php

return [
	'attributes'  => [
		'username'             => 'Username',
		'email'                => 'Email',
		'password'             => 'Password',
		'username_or_email'    => 'Username or Email',
		'body'                 => 'Comment',
		'release_date'         => 'Release Date',
		'genres'               => 'Genres',
	],
	'custom' => [
		'body' => [
			'required' => ':attribute is required.',
		],
		'picture' => [
			'required' => 'Please upload movie picture.',
		],
		'movie_id' => [
			'required' => 'Please choose a movie.',
		],
	],
];
