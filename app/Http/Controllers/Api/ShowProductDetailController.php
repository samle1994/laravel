<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class ShowProductDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $productDetail=Products::with('productRelate','files')->where(['id'=>$id,'is_status'=>1])->first();
        if(empty($productDetail)) {
            return response()->json(
                [
                    'errorCode'=>1,
                    'message'=>"Data null",
                    'status'=>401,
                ], 200
            );
        } else {
            $photo=array();
            $photos=$productDetail->files;
            foreach( $photos as $file) {
                $data=[
                    'id'=>$file->id,      
                    'photo'=>URL::to('/').'/uploads/gallery/'.$file->photo, 
                ]; 
                array_push($photo,$data);
            }
            //dd($photo);
            if($productDetail->photo!='') {
                $photo_detail=URL::to('/').'/uploads/product/'.$productDetail->photo;
            }
            else {
                $photo_detail='';
            }
            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>[
                        'id'=>$productDetail->id, 
                        'name'=>$productDetail->name,
                        'photo'=>$photo_detail,
                        'price'=>$productDetail->price,
                        'id_list'=>$productDetail->id_list,
                        'id_cat'=>$productDetail->id_cat,
                        'content'=>$productDetail->content,
                        'description'=>$productDetail->description,
                        'files'=>$photo,
                        'productRelate'=>$productDetail->productRelate
                    ],
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