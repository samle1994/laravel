<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductList;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;
class ProductListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_list=DB::select('select * from product_list');
        return response()->json(
            [
                'errorCode'=>0,
                'data'=>$product_list,
                'status'=>200
                
            ], 200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'name'=>'required',
        ]);

        if ($validator->fails()) {
  
            return response()->json(
                [
                    'errorCode'=>1,
                    'message'=>'Tên không được rỗng',
                    'status'=>401
                    
                ], 201
            );
        }
            $request->slug= Str::slug($request->name , "-");
            $product=ProductList::create([
                'name' => $request->name,
                'type' => 'product',
                'slug' => $request->slug
            ]
            );

            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>$product,
                    'status'=>200,
                ], 200
            );
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productDetail=ProductList::where('id', $id)->first();
        if(empty($productDetail)) {
            return response()->json(
                [
                    'errorCode'=>1,
                    'message'=>"Data null",
                    'status'=>401,
                ], 200
            );
        } else {
            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>$productDetail,
                    'status'=>200,
                ], 200
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}