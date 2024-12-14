<?php

use App\Http\Controllers\ResultInput;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\ResultInputController;

Route::get('/inputResult', [ResultInputController::class, 'index'])->name('inputResult');
Route::post('/submit-result', [ResultInputController::class, 'store'])->name('submitResult');
Route::delete('/result/delete/{id}', [ResultInputController::class, 'destroy'])->name('result.delete');


