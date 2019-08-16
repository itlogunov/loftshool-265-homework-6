<?php

require 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

try {
    $capsule = new Capsule;

    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => '127.0.0.1',
        'port'      => 8889,
        'database'  => '6_2',
        'username'  => 'root',
        'password'  => 'root',
        'charset'   => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix'    => '',
    ]);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    /**
     * Категории
     */
    Capsule::schema()->dropIfExists('categories');
    Capsule::schema()->create('categories', function ($table) {
        /** @var Blueprint $table */
        $table->bigIncrements('id');
        $table->unsignedBigInteger('parent_id');
        $table->tinyInteger('status')->default(0);
        $table->string('name');
        $table->string('code')->unique();
        $table->string('image');
        $table->text('description');
        $table->timestamps();
    });

    /**
     * Товары
     */
    Capsule::schema()->dropIfExists('products');
    Capsule::schema()->create('products', function ($table) {
        /** @var Blueprint $table */
        $table->bigIncrements('id');
        $table->unsignedBigInteger('categories_id');
        $table->tinyInteger('status')->default(0);
        $table->string('name');
        $table->string('code')->unique();
        $table->text('description');
        $table->float('price');
        $table->string('image');
        $table->smallInteger('color');
        $table->timestamps();
    });

    /**
     * Дополнительные изображения товаров
     */
    Capsule::schema()->dropIfExists('products_images');
    Capsule::schema()->create('products_images', function ($table) {
        /** @var Blueprint $table */
        $table->bigIncrements('id');
        $table->unsignedBigInteger('product_id');
        $table->string('image');
        $table->timestamps();
    });


} catch (Exception $e) {
    echo $e->getMessage();
    die();
}

echo 'Миграция успешно прошла!';
