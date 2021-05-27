<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartController extends Controller
{
  public function store(Request $request)
  {
    $productId = $request->productId;
    $userId = $request->user()->id;
    $cart = Cart::where('user_id',$userId)
             ->where('product_id',$productId)->first();

    if($cart != null)
    {
        $quantity = $cart->quantity;
        $newQuantity = $quantity + ($request->quantity);
        $cart->quantity=$newQuantity;
        $cart->save();
    }
    else
    {

    $detail  = new Cart();
    $detail -> user_id = $userId;
    $detail -> product_id = $productId;
    $detail -> quantity=$request->quantity;
    $detail -> price = Product::find($productId)->price;
    $detail -> save();
    }
    return response(['status' => true]);
  }

  public function show(Request $request)
  {
      $user = $request->user();

      $cart = $user->get();
      $cart->load('cart');
      return response(['data' => $cart]);
  }
  public function destroy(Request $request)
  {
      $user = $request->user();
      $user -> cart() -> delete();
      return response(['status' => true]);
  }
//   public function showByUser(User $user)
//   {
//     $products = $user->cart;
//     return response(['data'=>$products]);
//   }

    public function showByUser(Request $request)
    {
        $userId= $request->user()->id;

        $carts=Cart::where('user_id',$userId)
            ->with('users')
            ->with('products')
            ->with('products.categories')
            ->get();

        return response(['data'=>$carts]);
    }
}

