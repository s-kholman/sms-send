<?php

use App\Http\Controllers\AnalyticalController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientUploadController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\MailingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SmscIntegrationController;
use App\Http\Controllers\TestController;
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
Route::get('/', function (){
 return view('home');
})->name('home')->middleware('auth');

Route::get('clients', [ClientController::class, 'index'])->middleware('auth')->name('clients.index');
//Route::post('upload',[ClientUploadController::class, 'upload'])->name('clients.upload')->middleware('auth');
Route::post('upload',[ExcelController::class, 'upload'])->name('clients.upload')->middleware('auth');
Route::get('upload',[ClientController::class, 'index']);

Route::get('mailing', [MailingController::class, 'index'])->name('mailing.index')->middleware('auth');
Route::post('store', [MailingController::class, 'store'])->middleware('auth')->name('mailing.store');

Route::get('test', [TestController::class, 'index'])->middleware('auth');
Route::post('test', [TestController::class, 'test'])->middleware('auth')->name('test');

Route::get('report', [ReportController::class, 'index'])->middleware('auth');
Route::post('report', [ReportController::class, 'index'])->middleware('auth')->name('report.index');

Route::get('smsc', [SmscIntegrationController::class, 'index'])->middleware('auth')->name('smsc.index');
Route::post('smsc/store', [SmscIntegrationController::class, 'store'])->name('smsc.store')->middleware('auth');

Route::get('analytical', [AnalyticalController::class, 'index'])->middleware('auth');
Route::post('analytical', [AnalyticalController::class, 'index'])->middleware('auth')->name('analytical.between');

Route::get('department', [DepartmentController::class, 'index'])->middleware('auth');
Route::post('department', [DepartmentController::class, 'store'])->middleware('auth')->name('department.store');
