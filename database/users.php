<?php
require "../vendor/autoload.php";
require "../Bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('users', function ($table) {
    $table->id();
    $table->string('fullname', 50);
    $table->string('email')->unique();
    $table->string('password');
    $table->timestamps();
});