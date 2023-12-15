<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        $status=$this->order_status;
        $name=User::find($this->user_id)->name;
        if($status=='sent') $status='recived';
        else $status='sent';
        return [
            'order_id'=>$this->id,
            'user_name'=>$name,
            'order_status'=>$status,
            'payment_status'=>$this->payment_status
        ];
    }
}
