<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

// GET-маршрут: страница с формой
Route::get('/', [FormController::class, 'showForm'])->name('form.show');

// POST-маршрут: приём данных формы
Route::post('/submit', [FormController::class, 'submitForm'])->name('form.submit');

// GET-маршрут: страница со всеми отправленными данными в таблице
Route::get('/submissions', [FormController::class, 'showSubmissions'])->name('submissions.index');