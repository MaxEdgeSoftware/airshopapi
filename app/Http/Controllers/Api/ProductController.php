<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    public function fetchProducts($key)
    {
        $user = User::where('api_token', $key)->first();
        // $user = User::where('api_token', "test")->first();
        if (!$user) {
            return response()->json("login", 200);
        }
        $store = $user->store;

        $data = [
            'user' => $user,
            'store' => $user->store,
            'products' => $store == null ? null : $store->Products
        ];
        return response()->json($data, 200);
    }

    public function addProduct(Request $request)
    {
        $this->validate($request, [
            'market_id' => '',
            'Name' => ['required'],
            'Category' => ['required'],
            'Description' => ['required'],
            'Price' => ['required', ''],
            'Image' => ['required', 'file'],
        ]);

        $productid = substr(str_shuffle("1234567890ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 20);
        $path = $request->file('Image')->store('products', 'public');
        Product::create([
            'market_id' => $request->market_id,
            'Name' => $request->Name,
            'Category' => $request->Category,
            'Description' => $request->Description,
            'Price' => $request->Price,
            'Image' => $path,
            'Product_id' => $productid,
        ]);
        return response()->json(true, 200);
    }

    public function addProductSlideShow(Request $request)
    {

        $productid = substr(str_shuffle("1234567890ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"), 0, 20);
        $file = $request->file("upload");
        $path = $file->store("products", "public");
        $store = Market::where("id", $request->market_id)->first();

        if ($store->WhatsappNo == " " || empty($store->WhatsappNo) || $store->Phone == "") {
            return response()->json(false, 200);
        }
        $product = Product::create([
            'market_id' => $request->market_id,
            'Image' => $path,
            'Product_id' => $productid,
        ]);

        if ($product) {
            return response()->json(true, 200);
        } else {
            return response()->json(false, 200);
        }
    }

    public function fetchProduct($key, $product)
    {

        $user = User::where('api_token', $key)->first();
        // $user = User::where('api_token', "test")->first();
        if (!$user) {
            return response()->json("login", 200);
        }

        $product = Product::where("Product_id", $product)->first();
        $data = [
            "product" => $product
        ];
        return response()->json($data, 200);
    }
    public function updatePrice($product, $newprice)
    {

        $product = Product::where("Product_id", $product)->first();
        if (!$product) {
            return response()->json(200);
        }
        $product->Price = $newprice;
        $product->save();

        return response()->json(200);
    }

    public function updateDesc(Request $request, $product)
    {
        $product = Product::where("Product_id", $product)->first();
        if (!$product) {
            return response()->json(200);
        }
        $product->Description = $request->descr;
        $product->save();
        return response()->json(200);
    }

    public function updateImage(Request $request, $product)
    {
        $this->validate($request, [
            'logo' => ['required', 'file'],
        ]);

        $product = Product::where("Product_id", $product)->first();
        if (!$product) {
            return response()->json(200);
        }
        $path = $request->file('logo')->store('products', 'public');;
        $product->Image = $path;
        $product->save();
        return response()->json(200);
    }

    public function deleteProduct($product)
    {
        $product = Product::where("Product_id", $product)->first();
        if (!$product) {
            return response()->json(200);
        }

        $product->delete();
        return response()->json(200);
    }





    // nearme 
    public function getProducts($country)
    {
        $products = Product::with("PStore")->get();

        $theProducts = [];

        foreach ($products as $product) {
            if ($product->Pstore != null) {
                if ($product->PStore->country != null && $product->PStore->country == $country) {
                    array_push($theProducts, $product);
                    array_push($theProducts, $product);
                }
            }
        }
        shuffle($theProducts);
        return response()->json(["products" => $theProducts], 200);
    }

    public function getProduct($product)
    {
        $product = Product::with("PStore")->where("Product_id", $product)->first();
        $store = $product->market_id;

        $related = Product::with("PStore")->where("market_id", $store)->get();
        $relatedProducts = [];
        foreach ($related as $rProduct) {
            array_push($relatedProducts, $rProduct);
        }

        shuffle($relatedProducts);
        $data = [
            "product" => $product,
            "related" => $relatedProducts
        ];

        return response()->json($data, 200);
    }
}
