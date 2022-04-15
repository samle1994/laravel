<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\SessionUser;

use DB;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request )
    {
        $product=DB::select('select * from products');
        return response()->json(
            [
                'errorCode'=>0,
                'data'=>$product,
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
        if(empty($request->name)) {
            return response()->json(
                [
                    'errorCode'=>1,
                    'message'=>'Name not null',
                    'status'=>401
                    
                ], 2010
            );

        } elseif(empty($request->type)) {
            return response()->json(
                [
                    'errorCode'=>0,
                    'message'=>'Type not null',
                    'status'=>401
                    
                ], 200
            );
        } else {
            $product=Products::create($request->all());
            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>$product,
                    'status'=>200,
                ], 200
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productDetail=Products::where('id', $id)->first();
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
 
        $productUpdate=Products::where('id',$id)
        ->update($request->all());
       
        if($productUpdate) {
            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>$productUpdate,
                    'status'=>200,
                ], 200
            );
        } else {
            return response()->json(
                [
                    'errorCode'=>1,
                    'message'=>'Update fail',
                    'status'=>401,
                ], 200
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Products::where('id', $id)->delete();

        if($deleted) {
            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>$deleted,
                    'status'=>200,
                ], 200
            );
        } else {
            return response()->json(
                [
                    'errorCode'=>1,
                    'message'=>'Delete fail',
                    'status'=>401,
                ], 200
            );
        }
    }
}