<?php

use Illuminate\Http\Request;
// use Illuminate\Routing\Route;

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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'usuario'], function () {
        Route::post('', 'UsuarioController@store');
        Route::group(['prefix' => 'login'], function () {
            Route::post('', 'UsuarioController@consultarUsuario');
        });
    });
    Route::group(['prefix' => 'orden'], function () {
        Route::post('', 'OrdenController@store');
        Route::get('{id}', 'OrdenController@search');
        Route::group(['prefix' => 'listar'], function () {
            Route::get('{id}', 'OrdenController@listarOrdenes');
        });
        Route::group(['prefix' => 'reporte'], function () {
            Route::post('', 'OrdenController@reporte');
        });
    });
});
