<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (v $faker) {
	return [
		'title' => $faker->sentence(),
		'body' => $faker->text(),
		'slug' => 'test-thu-bai-viet',
		'slug_base' => '1252018',
		'image' => 'dep_zai.jpg',
		'user_id' => 1,
		'created_at' => now(),
		'updated_at' => now()
	];
});
