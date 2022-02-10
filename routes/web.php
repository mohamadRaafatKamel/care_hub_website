<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

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
// if (isset($_COOKIE['lang'])){
//     Route::redirect('/', $_COOKIE['lang']);
// }else{
    // Route::redirect('/', 'ar');
// }

Route::redirect('/', 'admin');

Route::group(['prefix' => '{language}' ,'where' => ['language' =>  '(ar|en)' ] ], function () {
    // Route::group(['namespace' => 'App\Http\Controllers\Front'], function () {

    //     Route::get('/', 'HomeController@index')->name('home');
    //     Route::post('callme', 'HomeController@callme')->name('home.callme');

    //     Route::group(['middleware'=>'auth'], function () {

    //         Route::get('/userinfo', 'HomeController@userinfo')->name('home.user.info');
    //         Route::post('userinfoupdate','HomeController@userInfoUpdate')->name('home.myuser.info.update');

    //         Route::get('/request', 'HomeController@userAllRequest')->name('user.all.request');
    //         Route::get('/request/{msg}/{id}', 'HomeController@userViewRequest')->name('user.view.request');

    //         Route::get('reqstate/{id}/{state}', 'HomeController@RequestState')->name('user.request.state');

    //         Route::get('/doctorrequest', 'HomeController@DoctorRequest')->name('user.doc.request');
    //         Route::get('docstate/{id}/{state}', 'HomeController@DocOrderState')->name('doc.order.state');

    //     });

    // });

    // Auth::routes();

});
