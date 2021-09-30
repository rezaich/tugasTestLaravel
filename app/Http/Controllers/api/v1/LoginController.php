<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {

        // $validator = FacadesValidator::make($request-> all(), [
        //     'user_name' => 'required|unique:posts|min:6',
        //     'password' => 'required|min:6',
        // ],
        // [
        //     'user_name.required' => 'isi user name',
        //     'password.required' => 'isi password'
        // ])->validate();

        $user_name = $request->user_name;
        $password = $request -> password;

        $user = User::where('user_name',$user_name)->first();
        if($user)
        {
            if(Hash::check($password, $user->password))
            {
                $user->api_token=Str::random(60);
                $user->save();

                return response(['token'=>$user->api_token]);
            }
            return response(['error'=>'password salah'],401);
        }
        else
        {
            return response(['error'=>'user name tidak tersedia'],401);
        }
    }

    public function logout(Request $request)
    {
        $user = $request -> user();
        $user -> api_token = null;
        $user -> save();

        return response(['success'=>true]);
    }

    public function register(Request $request)
    {
        $user = new User();
        $user ->name = $request -> name;
        $user ->user_name = $request -> user_name;
        $user ->password = Hash::make($request -> password);
        $user ->is_admin = $request -> is_admin;
        $user ->api_token = null;
        $user -> save();

        return response(['id'=>$user->id,'name'=>$user->name,'user_name'=>$user->user_name]);
    }
}
