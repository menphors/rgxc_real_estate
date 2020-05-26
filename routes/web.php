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

Route::get('administrator', 'AuthController@showLoginForm')->name('administrator');
Route::post('admin-login', 'AuthController@login')->name("user-login");
Route::post('admin-logout', 'AuthController@logout')->name("logout");
Route::get('password/email', 'AuthController@email');
Route::post('password/send-email', 'AuthController@sendEmail');
Route::get('email-password-success', 'AuthController@forgetPasswordSuccess');
Route::get('get-reset-password/{code}', 'AuthController@formResetPassword');
Route::post('reset-password', 'AuthController@postResetPassword');
Route::get('reset-password-success', 'AuthController@resetSuccess');

// front end route should be here and first uri should be language key.
Route::prefix('/')->group(function () {
    Route::get('/', 'FrontController@index')->name("home");
    Route::get('/properties', 'FrontController@properties');
    Route::get('/agents', 'FrontController@agents');
    Route::get('company-profile', 'FrontController@companyProfile')->name("company-profile");
    Route::get('service', 'FrontController@service')->name("service");
    Route::get('/contact', 'FrontController@contact')->name("contact");
    Route::post('/contact', 'FrontController@sendContact');
    Route::get('/property-detail/{id?}', 'FrontController@property_detail');
    Route::get('/agent-detail/{id?}', 'FrontController@agent_detail');
    Route::get('/get-district-by-province-id/{id?}', 'ProccessController@getDistrictByProvinceID');

    Route::get('blog/{slug}', 'FrontController@blogDetail')->name('blog');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
    Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
    // list all lfm routes here...
});

Route::prefix('global')->group(function () {
    Route::get('property/detail/{token}/{id_pdf?}', 'PropertyController@detail')->name("property-detail");
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
