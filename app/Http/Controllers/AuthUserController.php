<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthUserController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name'=>['required','unique:users,name'],
            'phone_number'=>['required','unique:users,phone_number','numeric','digits:10'],
            'password'=>['required','min:8'],
            'address'=>['required']
        ]);
        $user = User::query()->create([
            'name'=>$request->name,
            'phone_number'=>$request->phone_number,
            'password'=>bcrypt($request->password),
            'address'=>$request->address
        ]);
        $token=$user->createToken("token")->plainTextToken;
        $user['remember_token']=$token;
        $user->save();
        $data=[];
        $data['user']=$user;
        $data['token']=$token;
        return response()->json([
            'status'=>200,
            'data'=>$data,
            'message'=>'you are registerd successfully'
        ]);

    }


    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'phone_number'=>'required|digits:10',
            'password'=>'required|min:8'
        ]);
        $credential=[
            'phone_number'=>$request->phone_number,
            'password'=>$request->password
        ];
        if(!Auth::attempt($credential))
        {
            return response()->json([
                'status'=>400,
                'data'=>[],
                'message'=>'the information does not match our record'
            ]);
        }
        $user=User::query()->where('phone_number',$request->phone_number)->first();
        $token=$user->createToken("token")->plainTextToken;
        $data=[];
        $user['remember_token']=$token;
        $data['user']=$user;
        $data['token']=$token;
        $user->save();
        return response()->json([
            'status'=>200,
            'data'=>$data,
            'message'=>'you are logged in successfully'
        ]);
    }
    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();
       return response()->json([
            'status'=>200,
            'data'=>[],
            'message'=>'you are logged out successfully'
        ]);

    }
    public function show_user_info($id){

        $user_info=User::query()->where('id',$id)->first();
        return response()->json([
            'status'=>200,
            'data'=>$user_info,
        ]);
    }
}
