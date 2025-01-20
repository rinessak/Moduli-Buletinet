<?php
require "../vendor/autoload.php";
require "../Bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('positions', function ($table) {
    $table->id();
    $table->integer('faculty_id');
    $table->string('position', 200);
    $table->text('description')->nullable();
    $table->timestamps();
});