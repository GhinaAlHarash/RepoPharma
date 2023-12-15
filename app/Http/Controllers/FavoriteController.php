<?php

namespace App\Http\Controllers;

use App\Models\favorite;
use App\Models\medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function add_to_favorite($id){
        $medicine=medicine::query()->find($id);
        $favorite=favorite::query()
            ->where('medicine_id',$medicine)
            ->where('user_id',Auth::user()->id)
            ->get();
        $favorite=favorite::query()->create([
            'medicine_id'=>$id,
            'user_id'=>Auth::user()->id,
        ]);
        return response()->json([
            'status'=>200,
            'data'=>$favorite,
            'message'=>'the medicine has been added successfully'
        ]);
    }

    public function remove_from_favorite(Request $request, $id){
        $favorite=favorite::query()
            ->where('id',$id)
            ->delete();
        return response()->json([
            'status'=>200,
            'message'=>'the medicine has been deleted from fovorite page successfully'
        ]);
    }

    public function show_favorite(){
        $favorite=favorite::query()
            ->where('user_id',Auth::user()->id)
            ->get();
        return response()->json([
            'status'=>200,
            'data'=>$favorite,
        ]);
    }
}
