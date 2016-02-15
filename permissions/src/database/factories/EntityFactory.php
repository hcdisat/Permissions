<?php

use ITeam\Permissions\Models\Credential;
use ITeam\Permissions\Models\Network;
use ITeam\Permissions\Models\Permission;
use ITeam\Permissions\Models\Person;
use ITeam\Permissions\Models\PersonType;
use ITeam\Permissions\Models\Role;

$factory->define(PersonType::class, function(\Faker\Generator $faker) : array {
    return [
        'name' => $word = $faker->word(),
        'slug' => snake_case($word)
    ];
});


$factory->define(Person::class, function(\Faker\Generator $faker) : array {
    return [
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'person_type_id' => $faker->randomNumber(1)
    ];
});

$factory->define(Credential::class, function(\Faker\Generator $faker) : array {
    return [
        'person_id' => $faker->randomNumber(1),
        'username' => $faker->userName(),
        'password' => bcrypt('secret')
    ];
});

$factory->define(Network::class, function(\Faker\Generator $faker) : array {
    return [
        'name' => $faker->colorName(),
        'parent_id' => $faker->randomNumber(1),
        'owner_id' => $faker->randomNumber(1)
    ];
});

$factory->define(Role::class, function(\Faker\Generator $faker) : array {
    return [
        'name' => $word = $faker->word() . str_random(3),
        'slug' => strtolower(snake_case($word, '')),
        'description' => $faker->text()
    ];
});


$factory->define(Permission::class, function(\Faker\Generator $faker) : array {
    return [
        'name' => $word = $faker->word() . str_random(3),
        'slug' => strtolower(snake_case($word, '')),
        'description' => $faker->text()
    ];
});