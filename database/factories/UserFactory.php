<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => (rand(1, 3) > 1 ? $faker->firstNameMale() 
            : $faker->firstNameFemale()) . Str::random(2) . random_int(0, 999),

        'email' => $faker->unique()->safeEmail,

        'first_name' => $faker->firstNameMale(),
        'last_name' => $faker->lastName(),
        'briefly_about_myself' => $faker->sentence(rand(2, 6)),
        'about_myself' => $faker->realText(rand(10, 200)),

        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'created_at' => $created_at = $faker->dateTimeBetween('-2 years', '-2 weeks')
    ];
});
