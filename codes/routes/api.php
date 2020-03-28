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

Route::prefix('v1')->group(function($router){

    $router->post('user/register', 'V1\UserController@register');
    $router->middleware('oauth.providers')->post('user/login', 'V1\UserController@login');

    $router->get('faqs', 'V1\FaqsController@index');
    $router->get('faqs/{id}', 'V1\FaqsController@show')->where('id', '\d+');

    Route::middleware('auth:api')->group(function($router){
        $router->get('user/logout', 'V1\UserController@logout');
        $router->get('user/info', 'V1\UserController@info');

        $router->get('contact-messages', 'V1\ContactMessagesController@index');
        $router->post('contact-messages', 'V1\ContactMessagesController@store');
        $router->get('contact-messages/{id}', 'V1\ContactMessagesController@show')->where('id', '\d+');

    });
});