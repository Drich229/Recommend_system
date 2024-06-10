<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\File;
use App\Models\OrderProduct;
use App\Models\Cart;
use Illuminate\Http\Request;
use Auth;

class OrderController extends Controller
{
    public function createOrder(Request $request)
{

    $filePath = storage_path('data/cart_products.json');

    // Lire le fichier JSON existant
    if (File::exists($filePath)) {
        $json = File::get($filePath);
        $data = json_decode($json, true);
    } else {
        return back()->with('error', 'Your cart is empty.');
    }

    // Filtrer les produits du panier pour l'utilisateur authentifié
    $userCart = array_filter($data['cart_product'], function ($cartItem) {
        return $cartItem['user_id'] == Auth::id();
    });

    if (empty($userCart)) {
        return back()->with('error', 'Your cart is empty.');
    }

    // Calculer le total de la commande
    $total = array_reduce($userCart, function ($carry, $item) {
        return $carry + $item['amount'];
    }, 0);

    // Créer l'objet JSON pour la commande
    $order = [
        'id' => uniqid(),
        'user_id' => Auth::id(),
        'total' => $total,
        'created_at' => now()->toDateTimeString(),
        'updated_at' => now()->toDateTimeString()
    ];

    // Chemin vers le fichier JSON des commandes
    $orderFilePath = storage_path('data/orders.json');

    // Lire le fichier JSON des commandes existant
    if (File::exists($orderFilePath)) {
        $orderJson = File::get($orderFilePath);
        $orderData = json_decode($orderJson, true);
    } else {
        $orderData = ['orders' => []];
    }

    $orderData['orders'][] = $order;

    // Écrire les données mises à jour dans le fichier JSON des commandes
    File::put($orderFilePath, json_encode($orderData, JSON_PRETTY_PRINT));

    // Vider le panier de l'utilisateur
    $data['cart_product'] = array_filter($data['cart_product'], function ($cartItem) {
        return $cartItem['user_id'] != Auth::id();
    });

    // Écrire les données mises à jour dans le fichier JSON du panier
    File::put($filePath, json_encode($data, JSON_PRETTY_PRINT));
    request()->session()->flash('success','Commande créé avec succès');
    return redirect()->route('cart.show');
}
}