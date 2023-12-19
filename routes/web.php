<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PublicViewController;
use App\Http\Controllers\ReviewRatingController;



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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('buku');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/buku',[BukuController::class, 'index'])->name('buku');
    
    Route::get('buku/search', [BukuController::class, 'search'])->name('buku.search');
    Route::post('buku/review', [BukuController::class, 'reviewbuku'])->name('buku.review');
    Route::get('buku/rating', [BukuController::class, 'showRating'])->name('buku.rating');
    Route::get('buku/rating/{add}', [BukuController::class, 'addRating'])->name('buku.addrating');

    Route::middleware('admin')->group(function () {
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('buku', [BukuController::class, 'store'])->name('buku.store');
        Route::post('buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
        Route::get('buku/edit/{id}', [BukuController::class, 'edit'])->name('buku.edit');
        Route::post('buku/update/{id}', [BukuController::class, 'update'])->name('buku.update');
        Route::get('/buku/delete-gallery/{id}', [BukuController::class, 'deleteGalleryImage'])->name('deleteGalleryImage');
    });
});

require __DIR__.'/auth.php';

Route::get('/list', [BukuController::class, 'showList'])->name('buku.list');
Route::get('list/detail/{id}', [BukuController::class, 'galbuku'])->name('buku.detail');

Route::middleware('auth')->group(function () {
    Route::post('/favorite/{book}', [FavoriteController::class, 'toggleFavorite'])->name('favorite.toggle');
});

Route::get('/top-books', [BukuController::class, 'topBooks'])->name('buku.top10');

Route::get('/buku/reviews/{id}', [BukuController::class, 'showReviews'])->name('buku.reviews');
Route::post('/buku/reviews/{id}', [BukuController::class, 'storeReview'])->name('buku.storeReview');