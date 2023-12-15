<?php

namespace App\Http\Resources;

use App\Models\medicine;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Order_medicinesResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $med=medicine::where('id',$this->medicine_id)->first();
        return [
            'med_name'=>$med->commercial_name,
            'quantity'=>$this->needed_quantity,
            'med_price'=>$med->price,
            'quantity_price'=>$med->price*$this->needed_quantity
        ];
    }
}
