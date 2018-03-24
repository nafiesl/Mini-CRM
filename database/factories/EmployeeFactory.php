<?php

use App\Company;
use App\Employee;
use App\User;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {

    return [
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'company_id' => function () {
            return factory(Company::class)->create()->id;
        },
        'email'      => $faker->safeEmail,
        'phone'      => $faker->phoneNumber,
        'creator_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
