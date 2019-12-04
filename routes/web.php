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
//Home and About page
Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');

//Listings
Route::resource('listings', 'ListingsController');

//Authenticating
Auth::routes();

//Dashboard
Route::get('/dashboard', 'DashboardController@index');

//Search
Route::post('/listings/search', 'SearchController@search');
