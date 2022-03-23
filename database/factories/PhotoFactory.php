<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\Photo;
use App\Models\User;

$factory->define(Photo::class, function (Faker $faker) {
    return [
        'id' => Str::random(12),
        'user_id' => User::factory()->create()->id,
        'filename' => Str::random(12) . '.jpg',
        'created_at' => $faker->dateTime(),
        'updated_at' => $faker->dateTime(),
    ];
});