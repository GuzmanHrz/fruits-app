<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fruit;
use Illuminate\Support\Facades\Validator;



class FruitController extends Controller
{
    
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Fruit::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
       $validation = $this->data_validation($request);
       if ($validation) return $validation;
       $fruit = Fruit::create($request->all());
       return response()->json($fruit, 201);
 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Fruit  $fruit
     * @return \Illuminate\Http\Response
     */
    public function show(Fruit $fruit)
    {
        return $fruit;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Fruit          $fruit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  Fruit $fruit)
    {   
        
        $validation = $this->data_validation($request);
        if ($validation) return $validation;

        $fruit->update($request->all());
        return response()->json($fruit, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Fruit $fruit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fruit $fruit)
    {
        $fruit->delete();
        return response()->json(null, 204);


    }

    
    
    private function data_validation ($request) {
        
        $rules = [
            'name' => 'required',
            'size' => 'required|in:small,medium,large'
       ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            return response()->json($validator->errors(), 400); 
        }
        return $this->already_exists($request);
    }
    

    private function already_exists($request) {
        $exist = Fruit::where(['name' => $request->input('name'), 
                               'size' => $request->input('size'), 
                               'color' => $request->input('color') ])->exists();

        if ($exist) {
           return response()->json(['error' =>"Conflict, the fruit exist already in the DB"] , 409); 
        }

    }

   
}
