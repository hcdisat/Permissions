<?php

use HcDisat\Permissions\Models\Permission;
use HcDisat\Permissions\Models\Role;

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