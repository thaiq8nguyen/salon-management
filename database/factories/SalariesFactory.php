<?php
/**
 * Created by PhpStorm.
 * User: discoverylight
 * Date: 5/28/17
 * Time: 3:16 PM
 */
/*
|--------------------------------------------------------------------------
| Technician Salary Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Salary::class, function () {


    return [
        'commissioned' => 1,
        'commission_rate' => 0.6,
        'tip_rate' => 0.3,

    ];
});