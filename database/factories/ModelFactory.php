<?php

$factory->define(App\Admin::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' 		=> $faker->firstName,
        'email'		=> $faker->email,
        'mobile'	=> $faker->phoneNumber,
        'password' 	=> $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});