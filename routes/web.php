<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerMenu;
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

Route::resource('/', ControllerMenu::class);

Route::get('inputclub', [ControllerMenu::class, 'club'])->name('menu/inputclub');
Route::post('inputclub/process', [ControllerMenu::class, 'process_club'])->name('menu/inputclub/process');

Route::get('inputmatch', [ControllerMenu::class, 'match'])->name('menu/inputmatch');
Route::post('inputmatch/process', [ControllerMenu::class, 'process_match'])->name('menu.processscore');

Route::get('klasemen', [ControllerMenu::class, 'klasemen'])->name('menu/klasemen');