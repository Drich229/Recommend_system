<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;
use Helper;

class CartController extends Controller
{
    protected $product=null;
    public function __construct(Product $product){
        $this->product=$product;
    }

    public function addToCart($id){
        $products        = json_decode(file_get_contents(storage_path('data/products-data.json')));
        $selectedId      = intval($id ?? '8');
         $selectedProduct = $products[0];
            $selectedProducts = array_filter($products, function ($product) use ($selectedId) { return $product->id === $selectedId; });
            if (count($selectedProducts)) {
                $selectedProduct = $selectedProducts[array_keys($selectedProducts)[0]];
            }
        // return $product;
        /*if (empty($product)) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }      

        $already_cart = CartProduct::where('user_id', auth()->user()->id)->where('product_id', $product->id)->first();
        // return $already_cart;
        if($already_cart) {
            // dd($already_cart);
            $already_cart->quantity = $already_cart->quantity + 1;
            $already_cart->amount = $product->price+ $already_cart->amount;
            // return $already_cart->quantity;
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
            $already_cart->save();
            
        }else{
            
            $cart = new CartProduct;
            $cart->product_id = $selectedProduct->id;
            $cart->quantity = 1;
            $cart->price = $selectedProduct->price;
            $cart->amount=$cart->price*$cart->quantity;
            $cart->user_id = auth()->user()->id;
            //if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
            $cart->save();
        //}*/
        $filePath = storage_path('data/cart_products.json');

        if (File::exists($filePath)) {
            $json = File::get($filePath);
            $data = json_decode($json, true);
        } else {
            $data = ['cart_product' => []];
        }
    
        // Rechercher si le produit est déjà dans le panier
        $already_cart = null;
        foreach ($data['cart_product'] as &$cartItem) {
            if ($cartItem['user_id'] == Auth::id() && $cartItem['product_id'] == $selectedProduct->id) {
                $already_cart = &$cartItem;
                break;
            }
        }
    
        if ($already_cart) {
            // Mettre à jour la quantité et le montant
            $already_cart['quantity'] += 1;
            $already_cart['amount'] += $selectedProduct->price;
    
            // Vérifier le stock
            if ($selectedProduct->stock < $already_cart['quantity'] || $selectedProduct->stock <= 0) {
                return back()->with('error', 'Stock not sufficient!.');
            }
        } else {
        $cart = [
            'id' => uniqid(), // Génère un identifiant unique pour chaque enregistrement
            'product_id' => $selectedProduct->id,
            'product_name' => $selectedProduct->name,
            'quantity' => 1,
            'price' => $selectedProduct->price,
            'amount' => $selectedProduct->price * 1,
            'user_id' => auth()->user()->id,
            'created_at' => now()->toDateTimeString(),
            'updated_at' => now()->toDateTimeString()
        ];
        
        $data['cart_product'][] = $cart;
    }
        
        // Écrire les données mises à jour dans le fichier JSON
        File::put($filePath, json_encode($data, JSON_PRETTY_PRINT));
        request()->session()->flash('success','Produit ajouté au panier');
        return back();       
    }

    public function showCart(){
        // Chemin vers le fichier JSON
        $filePath = storage_path('data/cart_products.json');

        // Lire le fichier JSON existant
        if (File::exists($filePath)) {
            $json = File::get($filePath);
            $data = json_decode($json, true);
        } else {
            $data = ['cart_product' => []];
        }

        // Filtrer les produits du panier pour l'utilisateur authentifié
        $userCart = array_filter($data['cart_product'], function ($cartItem) {
            return $cartItem['user_id'] == Auth::id();
        });

        // Calculer le total du panier
         $total = array_reduce($userCart, function ($carry, $item) {
        return $carry + $item['amount'];
        }, 0);

        return view('cart', ['cartItems' => $userCart, 'total' => $total]);
    }

    public function removeFromCart($id)
{
    // Chemin vers le fichier JSON
    $filePath = storage_path('data/cart_products.json');

    // Lire le fichier JSON existant
    if (File::exists($filePath)) {
        $json = File::get($filePath);
        $data = json_decode($json, true);
    } else {
        $data = ['cart_product' => []];
    }

    // Filtrer les produits du panier pour l'utilisateur authentifié
    $data['cart_product'] = array_filter($data['cart_product'], function ($cartItem) use ($id) {
        return $cartItem['id'] != $id;
    });

    // Écrire les données mises à jour dans le fichier JSON
    File::put($filePath, json_encode($data, JSON_PRETTY_PRINT));

    return back()->with('success', 'Product removed from cart successfully!');
}
}