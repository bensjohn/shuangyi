<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->resource('users', UserController::class);

    $router->resource('up-data-lists', UpDataListController::class);

    $router->resource('car-class-datas', carClassDataController::class);

    $router->resource('insure-class-datas', InsureClassDataController::class);

    $router->resource('repair-class-datas', RepairClassDataController::class);

    $router->resource('car-datas', CarDataController::class);

    $router->resource('insure-datas', InsureDataController::class);


});
