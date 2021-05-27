<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = $request ->user();
        $user -> load('userDetail');
        return response(['user' => $user]);
    }

    public function store(Request $request)
    {
        $userId = $request -> user() -> id ;

        $detail = new UserDetail();
        $detail -> address = $request -> address;
        $detail -> phone = $request -> phone;
        $detail -> image_link = $request -> image_link;
        $detail -> user_id = $userId;
        $detail -> save();

        return response(['success'=> true]);
    }
    public function update(Request $request)
    {
        $detail = $request -> user()->userDetail;
        if(isset($request->address))
        {
            $detail ->address=$request->address;
        }
        if(isset($request->phone))
        {
            $detail->phone = $request -> phone;
        }
        $detail -> save();

        return response(['success'=> true]);
    }
}
