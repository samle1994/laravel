<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductList;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class ProductListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        $searchTerm= $request->input('keyword');
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $searchTerm = str_replace($reservedSymbols, ' ', $searchTerm);

        $searchValues = preg_split('/\s+/', $searchTerm, -1, PREG_SPLIT_NO_EMPTY);

       $page= $request->input('page');
        $pageLength= $request->input('pageLength');

        if($page!='') {
            $product_list=DB::table('product_list')->where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
                }
            })->offset($page*$pageLength)->take($pageLength)->get();
            
            $pageInfo=DB::table('product_list')->where(function ($q) use ($searchValues) {
                foreach ($searchValues as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
                }
            })->paginate($pageLength);

            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>$product_list,
                    'PageInfo'=>[
                        'total'=>$pageInfo->lastpage()
                    ],
                    'status'=>200
                ], 200
            );
        } else {
            $product_list= DB::table('product_list')->get();
            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>$product_list,
                    'status'=>200
                ], 200
            );
        }
       
        //dd($pageInfo);
       
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
   
        $value= $request->input('value');
        $type= $request->input('type');
     
        if($value!='' && $type!='') {

            $productUpdate=ProductList::where('id',$id)
            ->update([
                $type => $value
            ]);
        
        } else {
            
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
         $productUpdate=ProductList::where('id',$id)
        ->update([
            'name' => $request->name,
            'slug' => $request->slug
        ]);
         }
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
        $deleted = ProductList::where('id', $id)->delete();

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