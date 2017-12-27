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

use App\Models\Company;

//Главная страница
Route::get('/', 'HomeController@index');

//Это тестовые маршруты
Route::get('test/{string}', 'ParserController@getList');
Route::get('test/doom/{id}', 'ParserController@getCompany')->where('id', '\d+');
Route::get('test/regex/{id}', 'ParserController@regexGetCompany')->where('id', '\d+');

//Маршрут для ajax запросов
Route::group(['prefix'=>'ajax'], function () {
    Route::group(['prefix'=>'search'], function() {

        Route::get('address', 'AjaxController@searchAddress')
            ->name('ajax.search.address');

        Route::get('company', 'AjaxController@searchCompany')
            ->where('limit', '\d{1,2}')
            ->name('ajax.search.company');

        Route::get('opf', 'AjaxController@searchOpf')
            ->where('limit', '\d{1,2}')
            ->name('ajax.search.opf');

        Route::get('company_profile', 'AjaxController@searchCompanyProfile')
            ->name('ajax.search.company_profile');

    });

    Route::group(['prefix'=>'get'], function () {
        Route::get('company', 'AjaxController@getCompany')
            ->name('ajax.get.company');
    });

});

Route::group(['prefix'=>'company'], function () {

    Route::get('{id}', 'CompanyController@viewCompany')
        ->where('id', '\d+')
        ->name('company.view');

    Route::get('', 'CompanyController@viewAll')
        ->name('companies.view');

    Route::get('add', 'CompanyController@create')
        ->name('company.create');

    Route::post('add', 'CompanyController@store')
        ->name('company.store');
});

//TODO: Убрать перед публикацией
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    return "Кэш очищен.";
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('phone', 'PhoneController');
