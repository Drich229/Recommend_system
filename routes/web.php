<?php

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

Route::get('/', function () {
    $products        = json_decode(file_get_contents(storage_path('data/products-data.json')));
    return view('products.index', compact('products'));
});

