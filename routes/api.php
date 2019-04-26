<?php


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
Route::post('/auth/login', 'AuthController@login');

// Super Admin only routes
Route::group(['middleware' => ['auth:api', 'role:super admin']], function() {
    Route::get('/clients', 'ClientController@index');
    Route::get('/clients/{id}', 'ClientController@show');
    Route::post('/clients', 'ClientController@store');
    Route::put('/clients/{id}', 'ClientController@update');
    Route::delete('/clients/{id}', 'ClientController@destroy');
});

Route::group(['middleware' => ['auth:api', 'role:client admin']], function() {
    Route::get('/users', 'UserController@index');
    Route::get('/users/{id}', 'UserController@show');
    Route::post('/users', 'UserController@store');
    Route::put('/users/{id}', 'UserController@update');
    Route::delete('/users/{id}', 'UserController@destroy');

    Route::get('users/brands/{user_id}', 'UserController@getUserBrands');
    Route::get('users/brands/not/{user_id}', 'UserController@getNotUserBrands');
    Route::post('/users/brands/{userId}/{brandId}/{flag}', 'UserController@addUserBrand');

    Route::get('/requests', 'VerifiedRequestController@index');
    Route::get('/requests/{id}', 'VerifiedRequestController@show');
    Route::delete('/requests/{id}', 'VerifiedRequestController@destroy');

    Route::delete('/campaigns/{id}', 'CampaignController@destroy');

    Route::post('request/approve', 'VerifiedRequestController@directApprove');
    Route::get('/requests/approve/{id}', 'VerifiedRequestController@approve');
});

Route::group(['middleware' => ['auth:api', 'role:client user']], function() {

    Route::post('/brands', 'BrandController@store');
    Route::put('/brands/{id}', 'BrandController@update');
    Route::delete('/brands/{id}', 'BrandController@destroy');

    Route::post('/campaigns', 'CampaignController@store');
    Route::put('/campaigns/{id}', 'CampaignController@update');

});

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('/brands/clients/{client_id}', 'BrandController@getByClientId');
    Route::get('/campaigns/brands/{brand_id}', 'CampaignController@getByBrandId');
    Route::get('/campaigns/clients/{clientId}', 'CampaignController@getByClientId');

    Route::get('/auth/details', 'AuthController@details');
    Route::get('/auth/clients', 'AuthController@clients');
    Route::get('/auth/clientadmin', 'AuthController@clientAdmin');
    Route::get('/auth/logout', 'AuthController@logout');

    Route::post('/requests', 'VerifiedRequestController@store');

    Route::get('/brands', 'BrandController@index');
    Route::get('/brands/{id}', 'BrandController@show');

    Route::get('/campaigns', 'CampaignController@index');
    Route::get('/campaigns/{id}', 'CampaignController@show');
});
