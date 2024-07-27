<?php

use App\Http\Controllers\ProfileController;
use App\Infrastructure\Http\Controllers\Document\CheckDocumentController;
use App\Infrastructure\Http\Controllers\Document\DocumentController;
use App\Infrastructure\Http\Controllers\Setting\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('settings', SettingController::class)->except(['destroy']);

    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [CheckDocumentController::class, 'checkDocument'])->name('documents.check');
});

require __DIR__ . '/auth.php';
