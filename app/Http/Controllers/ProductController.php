<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $filePath = storage_path('data/products-data.json');

        if (File::exists($filePath)) {
            $json = File::get($filePath);
            $data = json_decode($json, true);
        } else {
            $data = ['product-data' => []];
        }

        // Vérifiez si la clé 'product-data' existe dans le tableau $data
        $products = isset($data['product-data']) ? $data['product-data'] : [];

        return view('manager.index', ['products' => $products]);
            }

    public function create()
    {
        return view('manager.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'required|string',
            'categories' => 'required|string',
            'features' => 'required|array',
        ]);

        $filePath = storage_path('data/products-data.json');

        if (File::exists($filePath)) {
            $json = File::get($filePath);
            $data = json_decode($json, true);
        } else {
            $data = ['products' => []];
        }

        $product = [
            'id' => count($data['products']) + 1,
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),
            'categories' => $request->input('categories'),
            'features' => $request->input('features'),
        ];

        $data['products'][] = $product;

        File::put($filePath, json_encode($data, JSON_PRETTY_PRINT));

        return redirect()->route('manager.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $filePath = storage_path('data/products-data.json');

        if (File::exists($filePath)) {
            $json = File::get($filePath);
            $data = json_decode($json, true);
        } else {
            return redirect()->route('dash')->with('error', 'Product not found.');
        }

        $product = collect($data['products'])->firstWhere('id', $id);

        if (!$product) {
            return redirect()->route('dash')->with('error', 'Product not found.');
        }

        return view('manager.edit', ['product' => $product]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'required|string',
            'categories' => 'required|string',
            'features' => 'required|array',
        ]);

        $filePath = storage_path('data/products.json');

        if (File::exists($filePath)) {
            $json = File::get($filePath);
            $data = json_decode($json, true);
        } else {
            return redirect()->route('manager.index')->with('error', 'Product not found.');
        }

        $productIndex = collect($data['products'])->search(function ($product) use ($id) {
            return $product['id'] == $id;
        });

        if ($productIndex === false) {
            return redirect()->route('manager.index')->with('error', 'Product not found.');
        }

        $data['products'][$productIndex]['name'] = $request->input('name');
        $data['products'][$productIndex]['price'] = $request->input('price');
        $data['products'][$productIndex]['stock'] = $request->input('stock');
        $data['products'][$productIndex]['description'] = $request->input('description');
        $data['products'][$productIndex]['image'] = $request->input('image');
        $data['products'][$productIndex]['categories'] = $request->input('categories');
        $data['products'][$productIndex]['features'] = $request->input('features');

        File::put($filePath, json_encode($data, JSON_PRETTY_PRINT));

        return redirect()->route('manager.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $filePath = storage_path('data/products-data.json');

        if (File::exists($filePath)) {
            $json = File::get($filePath);
            $data = json_decode($json, true);
        } else {
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }

        $productIndex = collect($data['products'])->search(function ($product) use ($id) {
            return $product['id'] == $id;
        });

        if ($productIndex === false) {
            return redirect()->route('products.index')->with('error', 'Product not found.');
        }

        array_splice($data['products'], $productIndex, 1);

        File::put($filePath, json_encode($data, JSON_PRETTY_PRINT));

        return redirect()->route('manager.index')->with('success', 'Product deleted successfully!');
    }
}
