<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Todos;

class TodosController extends Controller
{
    public function GetTodos(){
        $todos = Todos::all();

        return response()->json([
            'data' => [
                'items' => $todos,
            ]
        ],200);
    }

    public function AddTodos(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'completed' => 'required|boolean'
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ]
            ],422);
        }

        $todos = new Todos();
        $todos->name = $request->name;
        $todos->completed = $request->completed;
        $todos->save();

        return response()->json([], 204);
    }

    public function UpdateTodos(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required|string',
            'completed' => 'required|boolean'
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ]
            ],422);
        }

        Todos::find($request->id)
            ->update(array(
                'id' => $request->id,
                'name' => $request->name,
                'completed' => $request->completed
            ));

        return response()->json([], 204);
    }
    public function DeleteTodos(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Validation error',
                    'errors' => $validator->errors(),
                ]
            ],422);
        }

        Todos::find($request->id)
            ->delete();

        return response()->json([], 204);
    }
}
