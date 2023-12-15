<?php

namespace App\Http\Controllers;

use App\Http\Resources\Order_medicinesResource;
use App\Http\Resources\OrdersResource;
use App\Models\medicine;
use App\Models\order;
use App\Models\order_medicine;
use App\Models\order_medicines;
use App\Models\orderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderesController extends Controller
{
    public function show_orders($user_id){
        $user=User::find($user_id);
        if(!auth()->user()->is_admin){
            $orders=order::where('user_id',$user_id)->get();
            /*$allorders=order::where('user_id',$user_id)->first();
            $orders=[];
            $i=0;
            foreach($allorders as $order){
                //$orders[];
            }*/
        }
        else
            $orders=OrdersResource::collection(order::all());
        return response()->json([
            'status'=>200,
            'data'=>$orders,
            'message'=>'orders sent successfully'
        ]);
    }

    public function show_order_info($order_id){
        $meds=Order_medicinesResource::collection(order_medicine::where('order_id',$order_id)->get());
        $totalPrice=0;
        $date=order::find($order_id)->created_at;
        foreach($meds as $med){
            $totalPrice+=$med->quantityPrice;
        }
        return response()->json([
            'status'=>200,
            'data'=>[
                'meds'=>$meds,
                'total_price'=>$totalPrice,
                'date'=>$date
            ],
            'message'=>'order info sent successfully'
        ]);
    }


    public function change_order_status(Request $request,$id){
        $order=order::findorFail($id);
        $order->update([
            'order_status'=>$request->order_status
        ]);
        return response()->json([
            'status'=>200,
            'data'=>$order,
            'message'=>'order status updated successfully'
        ]);
    }

    public function change_payment_status(Request $request ,$id){
        $order=order::findorFail($id);
        $order->update([
            'payment_status'=>$request->payment_status
        ]);
        return response()->json([
            'status'=>200,
            'data'=>$order,
            'message'=>'order status updated successfully'
        ]);
    }

    public function new_order(Request $request){

        foreach ($request->orderMedicines as $orderMedicine){
            $med=medicine::where('id',$orderMedicine['medicine_id'])->first();
            if($med->total_quantity < $orderMedicine['needed_quantity']){
                return response()->json([
                    'status'=>200,
                    'data'=>$med->commercial_name,
                    'message'=>'the needed quantity is not obtainable'
                ]);
            }
        }


        $order=order::create([
            'user_id'=>$request->user_id
        ]);
        $order->save();
        $id=$order->id;

        foreach ($request->orderMedicines as $orderMedicine){
            $med=order_medicine::create([
                'order_id'=>$id,
                'medicine_id'=>$orderMedicine['medicine_id'],
                'needed_quantity'=>$orderMedicine['needed_quantity']
            ]);

            $medicine=medicine::where('id',$orderMedicine['medicine_id'])->first();
            $medicine->update([
                'total_quantity'=>$medicine->total_quantity-$orderMedicine['needed_quantity']
            ]);
        }
        return response()->json([
            'status'=>200,
            'data'=>$order,
            'message'=>'order saved successfully'
        ]);

    }
}
