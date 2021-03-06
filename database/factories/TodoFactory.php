<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Todo;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Todo::class, function (Faker $faker) {
    return [
        'user_id' => function (array $profile) {
            return User::find(1)->id;
        },
        'title' => $faker->title,
        'description' => $faker->text,
        'is_completed' => 0,
        'slug' => $faker->slug,
    ];
});
