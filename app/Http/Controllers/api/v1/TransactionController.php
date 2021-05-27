<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Transaction;
use Carbon\Carbon;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $userId = $request -> user()->id;

        $carts = Cart::where('user_id',$userId)->get();
         if(count($carts) !=0)
         {
             $transactions = new Transaction;
             $transactions->datetime=Carbon::now();
             $transactions->user_id = $userId;
             $transactions->save();

            //save to product_transactions
             $totalCost = 0;
             foreach($carts as $cart)
             {
                 $totalCost += (($cart->quantity)*($cart->price));
                 $transactions -> products()
                 ->attach($cart->product_id,['quantity'=> $cart->quantity,'price'=>$cart->price]);
             }
            //update total cost in transaction
             $transactions=Transaction::where('id',$transactions->id);
             $transactions->update(['total_cost'=> $totalCost]);

             Cart::where('user_id',$userId)->delete();
             return response(['success'=>true]);
         }
         else
         {
            return response(['success'=>false,'message'=>'the carts is empty']);
         }
    }
}
