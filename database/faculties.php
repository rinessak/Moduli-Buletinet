<?php
require "../vendor/autoload.php";
require "../Bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('faculties', function ($table) {
    $table->id();
    $table->string('name', 255)->unique();
});