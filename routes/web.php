<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientUploadController;
use App\Http\Controllers\MailingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SmscIntegrationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {    return view('welcome');});

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('clients', [ClientController::class, 'index'])->middleware('auth')->name('clients.index');
Route::post('upload',[ClientUploadController::class, 'upload'])->name('clients.upload')->middleware('auth');
Route::get('upload',[ClientController::class, 'index']);

Route::get('mailing', [MailingController::class, 'index'])->name('mailing.index')->middleware('auth');
Route::post('store', [MailingController::class, 'store'])->middleware('auth')->name('mailing.store');
Route::post('send', [MailingController::class, 'send'])->middleware('auth')->name('mailing.send');

Route::get('report', [ReportController::class, 'index'])->middleware('auth');
Route::post('find', [ReportController::class, 'find'])->middleware('auth')->name('report.find');

Route::get('smsc', [SmscIntegrationController::class, 'index'])->middleware('auth')->name('smsc.index');
Route::post('smsc/store', [SmscIntegrationController::class, 'store'])->name('smsc.store')->middleware('auth');
