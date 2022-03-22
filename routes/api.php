<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'languages'
],function ($router){
    $router->post('','App\Http\Controllers\LanguageController@create');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'articles'
],function ($router){
    $router->post('','App\Http\Controllers\ArticleController@create');
    $router->put('','App\Http\Controllers\ArticleController@update');
    $router->get('','App\Http\Controllers\ArticleController@readAll');
});
