<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    // $router->get('chartjs', 'ChartjsController@index')->name('admin.chartjs');
    $router->resource('/news/category', CategoryController::class);
    $router->resource('/news/article', ArticleController::class);
    $router->resource('signup', SignupController::class);
});
