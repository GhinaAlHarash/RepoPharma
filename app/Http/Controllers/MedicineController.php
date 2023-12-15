<?php

namespace App\Http\Controllers;

use App\Models\classification;
use App\Models\medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Runner\ClassIsAbstractException;

class MedicineController extends Controller
{
    public function show_classifications(Request $request)
    {
        $classification = classification::query()->get();
        return response()->json([
            'status' => 200,
            'data' => $classification,
            'message' => ' show classifications successfully'
        ]);
    }

   /* public function show_medicines_classification(Request $request)
    {
        $classification = classification::query()->get();
        $medicines_classification = [];
        foreach ($classification as $classification) {
            $medicines_classification[] = classification::query()->with('medicines')
                ->find($classification['id']);
        }
        return response()->json([
            'status' => 200,
            'data' => $medicines_classification,
        ]);
    }*/

       public function show_medicines($classification_id){
           $medicine=medicine::query()
               ->where('classification_id',$classification_id)
               ->get();
           return response()->json([
               'status'=>200,
               'data'=>$medicine,
           ]);
       }

    public function show_medicine_info(Request $request, $id)
    {

        $medincine = medicine::query()->where('id', $id)->first();
        return response()->json([
            'status' => 200,
            'data' => $medincine,
        ]);
    }

    public function update_medicine(Request $request, $id)
    {
        if (Auth()->user()->is_admin) {
            $medicine = medicine::query()->find($id);
            if (!$medicine) {
                return response()->json([
                    'status' => 400,
                    'data' => [],
                    'message' => 'the id is invalid'
                ]);
            }
            $validator = Validator::make($request->all(), [
                'scientific_name' => 'required',
                'commercial_name' => 'required',
                'company' => 'required',
                'total_quantity' => 'required',
                'price' => 'required',
                'classification_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 200,
                    'data' => [],
                    'message' => 'please fill out all fields'
                ]);
            }
            $medicine = medicine::query()->where('id', $id)->update([
                'scientific_name' => $request->scientific_name,
                'commercial_name' => $request->commercial_name,
                'company' => $request->company,
                'total_quantity' => $request->total_quantity,
                'price' => $request->price,
                'classification_id' => $request->classification_id
            ]);
            return response()->json([
                'status' => 200,
                'data' => $medicine,
                'message' => 'the medicine has been updated successfully'
            ]);
        }
    }

    public function add_medicine(Request $request)
    {

        if (Auth()->user()->is_admin) {
            $validator = Validator::make($request->all(), [
                'scientific_name' => 'required',
                'commercial_name' => 'required',
                'company' => 'required',
                'total_quantity' => 'required',
                'exp_date' => 'required',
                'price' => 'required',
                'classification_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'data' => [],
                    'message' => 'please fill out all fields'
                ]);
            }
            if (!medicine::query()->where('commercial_name', $request->commercial_name)->exists()) {
                $medicine = medicine::query()->create([
                    'scientific_name' => $request->scientific_name,
                    'commercial_name' => $request->commercial_name,
                    'company' => $request->company,
                    'total_quantity' => $request->total_quantity,
                    'exp_date' => $request->exp_date,
                    'price' => $request->price,
                    'classification_id' => $request->classification_id
                ]);
                return response()->json([
                    'status' => 1,
                    'data' => $medicine,
                    'message' => 'the medicine has been added successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'data' => [],
                    'message' => 'the medicine is already exists'
                ]);
            }
        }
    }


    public function add_classification(Request $request)
    {

        if (Auth()->user()->is_admin) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'data' => [],
                    'message' => 'please fill out all fields'
                ]);
            }
            if (!classification::query()->where('name', $request->name)->exists()) {
                $classification = classification::query()->create([
                    'name' => $request->name,
                ]);
                return response()->json([
                    'status' => 1,
                    'data' => $classification,
                    'message' => 'the classification has been added successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'data' => [],
                    'message' => 'the classification is already exists'
                ]);
            }
        }
    }


    public function search_medicine(Request $request)
    {

        $commercial_name = $request->input('commercial_name');
        $medicine = medicine::query()->where('commercial_name', 'like', "%$commercial_name%")->get();
        return response()->json([
            'status' => 200,
            'data' => $medicine
        ]);
    }


   /* public function show_medicines_classification(Request $request)
    {

        $classification_id = $request->input('classification_id');
        $medincines = medincin::get();
    foreach ($medincines as $medicine)
    {
        $medincine = medicine::where('classification_id', 'like', "%classification_id%")->get();
        if($medicine){
            return response()->json([
            'status' => 200,
            'data' => $medincine,
        ]);
        }
    }*/


}

