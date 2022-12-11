<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use PDO;

class CartController extends Controller
{
    public function addProductToCart($id, $qty){
    
        $product = Product::find($id);

        $cart = session()->get('cart') ?? [];
        $totalPrice = session()->get('total_price') ?? 0;
        
        //Add product 
        $cart[$id]['qty'] = ($cart[$id]['qty'] ?? 0) + $qty;
        $cart[$id]['price'] = $product->price;
        $cart[$id]['name'] = $product->name;
        $cart[$id]['image'] = $product->image;
        $totalPrice += ($qty * $product->price);
        $totalItems = count($cart);

        session()->put('cart', $cart);
        session()->put('total_price', $totalPrice);
        session()->put('total_items', $totalItems);

        return response()->json(['total_price' => number_format($totalPrice,2), 'total_items' => $totalItems]);
    }

    public function shoppingCart(){

        // session()->flush();
        
        $cart = session()->get('cart') ?? [];
        // dd($cart);

        return view('frontend.shopping_cart')->with('cart', $cart);
    }

    public function deleteCart(){
        session()->flush();
        return redirect()->route('shopping.cart');
    }

    public function deleteItemCart($id){
        $cart = session()->get('cart') ?? [];

        // foreach($cart as $idCart => $item){
        //     if($idCart == $id){
        //         unset($cart[$idCart]);
        //     }
        // }

        if(array_key_exists($id, $cart)){
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return redirect()->route('shopping.cart');
    }


    public function getCheckout(){

        $cart = session()->get('cart') ?? [];

        return view('frontend.checkout')->with('cart', $cart);
    }

    public function updateCart(Request $request){

        $cart = session()->get('cart') ?? [];
        

        $list = $request->list;
        foreach($list as $item){
            if(array_key_exists($item['id'], $cart)){
                $cart[$item['id']]['qty'] = $item['qty'];
            }
        }

        session()->put('cart', $cart);

        return response()->json(['cart' => $cart]);
    }
}
