<?php
require "../vendor/autoload.php";
require "../Bootstrap.php";

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create("bulletins", function($table){
    $table->id();
    $table->integer('faculty_id');
    $table->integer('position_id')->nullable();
    $table->string('bulletin_title', 255);
    $table->string('pdf_file_path', 255);
    $table->text('description')->nullable();
    // $table->boolean('is_active')->default(false);
    $table->dateTime('published_at')->useCurrent();
    // $table->dateTime('expired_at')->useCurrent();
    $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
});