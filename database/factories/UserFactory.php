<?php

namespace Database\Factories;

use Illuminate\Support\Str;

$factory->define(\Mirror\Core\Accounts\Entities\User::class, function(\Faker\Generator $faker) {
    return [
        'name' => $faker->name(),
        'email' => $faker->unique()->safeEmail(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
