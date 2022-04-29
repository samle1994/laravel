<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
class SearchProductController extends Controller
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
        $product=Products::with('productList','productCat')->where(function ($q) use ($searchValues) {
            foreach ($searchValues as $value) {
            $q->orWhere('name', 'like', "%{$value}%");
            }
        })->where('is_status',1)->orderBy('id', 'DESC')->offset($page*$pageLength)->take($pageLength)->get();
        $pageInfo=Products::where(function ($q) use ($searchValues) {
            foreach ($searchValues as $value) {
            $q->orWhere('name', 'like', "%{$value}%");
            }
        })->where('is_status',1)->paginate($pageLength);
        
        $data=array();
        foreach($product as $pro) {
            
            $data_array=[
            'id'=>$pro->id, 
            'name'=>$pro->name,
            'price'=>$pro->price,
            'id_list'=>$pro->id_list,
            'id_cat'=>$pro->id_cat,
            'product_cat'=>$pro->productCat,
            'product_list'=>$pro->productList,
            'is_status'=>$pro->is_status,
            'hot'=>$pro->hot,
            'news'=>$pro->news,
            'sale'=>$pro->sale,
            'photo'=>URL::to('/').'/uploads/product/'.$pro->photo,
            ];
            array_push($data,$data_array);
        }
        //dd($product);
        return response()->json(
            [
                'errorCode'=>0,
                'data'=>$data,
                'PageInfo'=>[
                    'total'=>$pageInfo->lastpage()
                ],
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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