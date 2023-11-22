<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

//Belum Login
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/commissions', function () {
    return view('user.commission');
});
Route::get('/about', function () {
    return view('user.about');
});
Route::get('/shop', [UserController::class, 'shop'])->name('shop');
Route::get('/productdetail/{id}', [UserController::class, 'productDetail'])->name('productDetail');

//Udah Login
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
    Route::get('/home/commissions', function () {
        return view('user.commission');
    });
    Route::get('/home/about', function () {
        return view('user.about');
    });
    Route::get('/home/shop', [UserController::class, 'shop'])->name('shop');
    Route::post('/home/shopping-cart', [UserController::class, 'store'])->name('add_to_shopping-cart');
    Route::get('/home/shopping-cart', [UserController::class, 'index'])->name('shopping-cart.get');
    Route::post('/home/shopping-cart/{id}', [UserController::class, 'shopping_cart'])->name('shopping-cart');
    Route::post('/home/thankyou', [UserController::class, 'thanks'])->name('thanksPage');
    Route::get('/home/productdetail/{id}', [UserController::class, 'productDetail'])->name('productDetail');

    Route::post('/updateCartItem', [UserController::class, 'update'])->name('updateCartItem');
    Route::post('/removeCartItem', [UserController::class, 'destroy'])->name('removeCartItem');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('product', AdminController::class);
    Route::resource('admin', AdminController::class);
    Route::get('home/admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::get('home/admin/{id}', [AdminController::class, 'show'])->name('admin.show');
    Route::get('home/admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
