<?php

return [
	'required'                => 'გთხოვთ შეიყვანოთ :attribute.',
	'numeric'                 => ':attribute უნდა იყოს რიცხვი.',
	'image'                   => 'გთხოვთ სწორად აირჩიეთ სურათის ფორმატი.',
	'unique'                  => ':attribute უკვე დაკავებულია.',
	'exists'                  => 'ასეთი :attribute არ არსებობს.',
	'same'                    => ':attribute არ ემთხვევა პაროლს.',
	'email'                   => 'გთხოვთ შეიყვანოთ ვალიდური ელ-ფოსტის მისამართი.',
	'required_with'           => 'გთხოვთ შეავსოთ :attribute.',
	'min'                     => [
		'string' => ':attribute უნდა შედგებოდეს მინიმუმ :min სიმბოლოსგან.',
	],
	'max'         => [
		'string' => ':attribute უნდა შედგებოდეს მაქსიმუმ :max სიმბოლოსგან.',
	],
	'custom' => [
		'body' => [
			'required' => 'გთხოვთ შეიყვანოთ :attribute.',
		],
		'picture' => [
			'required' => 'გთხოვთ ატვირთოთ ფილმის სურათი.',
		],
		'genres' => [
			'required' => 'გთხოვთ აირჩიოთ ფილმის ჟანრი',
		],
		'movie_id' => [
			'required' => 'გთხოვთ აირჩიოთ ფილმი.',
		],
	],
	'attributes'    => [
		'username'                          => 'მომხმარებლის სახელი',
		'email'                             => 'ელ-ფოსტა',
		'password'                          => 'პაროლი',
		'password_confirmation'             => 'განმეორებითი პაროლი',
		'username_or_email'                 => 'მომხმარებლის სახელი ან ელ-ფოსტა',
		'body'                              => 'კომენტარი',
		'picture'                           => 'სურათი',
		'release_date'                      => 'გამოშვების წელი',
		'genres'                            => 'ჟანრები',
		'movie_id'                          => 'ფილმი',
	],
];
