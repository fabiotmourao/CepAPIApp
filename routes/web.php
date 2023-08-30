<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CepController;

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

Route::get('/', [CepController::class, 'index']);
Route::post('/consultar-cep', [CepController::class, 'consultar'])->name('consultar-cep');
Route::get('/exportar/arquivo/{ceps?}', [CepController::class, 'exportar'])->name('exportar');
