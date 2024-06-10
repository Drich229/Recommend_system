<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\ProductController;



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
Route::get('/dash', function () {
    $products        = json_decode(file_get_contents(storage_path('data/products-data.json')));
    return view('products.index', compact('products'));
})->middleware(['auth', 'verified'])->name('dash');

Route::get('/product/{id}', function ($id) {
    $products        = json_decode(file_get_contents(storage_path('data/products-data.json')));
    $selectedId      = intval($id ?? '8');
    $selectedProduct = $products[0];

    $selectedProducts = array_filter($products, function ($product) use ($selectedId) { return $product->id === $selectedId; });
    if (count($selectedProducts)) {
        $selectedProduct = $selectedProducts[array_keys($selectedProducts)[0]];
    }

    $productSimilarity = new App\ProductSimilarity($products);
    $similarityMatrix  = $productSimilarity->calculateSimilarityMatrix();
    $products          = $productSimilarity->getProductsSortedBySimularity($selectedId, $similarityMatrix);
    
    return view('products.show', compact('selectedId', 'selectedProduct', 'products'));
})->name('products.show');

Route::get('/regis', [RegisteredUserController::class, 'create']);
Route::get('/log', [AuthenticatedSessionController::class, 'create']);
Route::get('/', function(){
    return view('welcome');}
);

// routes orders
Route::post('/order', [OrderController::class, 'createOrder'])->name('order.create');

//routes carts
Route::get('/add-to-cart/{id}',[CartController::class, 'addToCart'])->name('add-to-cart');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::delete('/cart/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('cart-update','CartController@cartUpdate')->name('cart.update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/prods', [ProductController::class, 'index'])->name('prods');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
});

require __DIR__.'/auth.php';
