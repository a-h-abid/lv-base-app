<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$router->middleware('guest:admin')->group(function($router){
    $router->get('/', 'AuthController@index')->name('login');
    $router->post('/', 'AuthController@login');
});

$router->middleware('auth:admin')->group(function($router){
    $router->get('logout', 'AuthController@logout')->name('logout');
    $router->get('dashboard', 'DashboardController@index')->name('dashboard');
    $router->get('change-password', 'ChangePasswordController@index')->name('change-password');
    $router->post('change-password', 'ChangePasswordController@update');

    Route::prefix('users')->name('users.')->group(function($router){

        Route::middleware('permission:admin.users.admins')->group(function($router) {
            $router->get('admins', 'Users\AdminsController@index')->name('admins.index');
            $router->get('admins/create', 'Users\AdminsController@create')->name('admins.create');
            $router->post('admins', 'Users\AdminsController@store')->name('admins.store');
            $router->get('admins/{id}/edit', 'Users\AdminsController@edit')->name('admins.edit')->where('id', '\d+');
            $router->put('admins/{id}', 'Users\AdminsController@update')->name('admins.update')->where('id', '\d+');
            $router->delete('admins/{id}', 'Users\AdminsController@destroy')->name('admins.destroy')->where('id', '\d+');
        });

        Route::middleware('permission:admin.users.users')->group(function($router) {
            $router->get('users', 'Users\UsersController@index')->name('users.index');
            $router->get('users/create', 'Users\UsersController@create')->name('users.create');
            $router->post('users', 'Users\UsersController@store')->name('users.store');
            $router->get('users/{id}/edit', 'Users\UsersController@edit')->name('users.edit')->where('id', '\d+');
            $router->put('users/{id}', 'Users\UsersController@update')->name('users.update')->where('id', '\d+');
            $router->delete('users/{id}', 'Users\UsersController@destroy')->name('users.destroy')->where('id', '\d+');
        });

        Route::middleware('permission:admin.users.roles')->group(function($router) {
            $router->get('roles', 'Users\RolesController@index')->name('roles.index');
            $router->get('roles/create', 'Users\RolesController@create')->name('roles.create');
            $router->post('roles', 'Users\RolesController@store')->name('roles.store');
            $router->get('roles/{id}/edit', 'Users\RolesController@edit')->name('roles.edit')->where('id', '\d+');
            $router->put('roles/{id}', 'Users\RolesController@update')->name('roles.update')->where('id', '\d+');
            $router->delete('roles/{id}', 'Users\RolesController@destroy')->name('roles.destroy')->where('id', '\d+');
            $router->get('roles/{id}/permissions', 'Users\RolesPermissionsController@edit')->name('roles-permissions.edit');
            $router->put('roles/{id}/permissions', 'Users\RolesPermissionsController@update')->name('roles-permissions.update');
        });
    });

    Route::prefix('common')->name('common.')->group(function($router) {
        Route::middleware('permission:admin.common.faqs')->group(function($router) {
            $router->get('faqs', 'Common\FaqsController@index')->name('faqs.index');
            $router->get('faqs/create', 'Common\FaqsController@create')->name('faqs.create');
            $router->post('faqs', 'Common\FaqsController@store')->name('faqs.store');
            $router->get('faqs/{id}/edit', 'Common\FaqsController@edit')->name('faqs.edit')->where('id', '\d+');
            $router->put('faqs/{id}', 'Common\FaqsController@update')->name('faqs.update')->where('id', '\d+');
            $router->delete('faqs/{id}', 'Common\FaqsController@destroy')->name('faqs.destroy')->where('id', '\d+');
        });

        Route::middleware('permission:admin.common.contact-messages')->group(function($router) {
            $router->get('contact-messages', 'Common\ContactMessagesController@index')->name('contact-messages.index');
            $router->get('contact-messages/{id}', 'Common\ContactMessagesController@show')->name('contact-messages.show')->where('id', '\d+');
            $router->delete('contact-messages/{id}', 'Common\ContactMessagesController@destroy')->name('contact-messages.destroy')->where('id', '\d+');
        });
    });

    Route::prefix('app')->name('app.')->group(function($router) {
        // App Specific Admin Routes
    });

});

$router->fallback('ErrorController@notFound');
