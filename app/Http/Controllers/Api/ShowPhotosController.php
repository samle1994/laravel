<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class ShowPhotosController extends Controller
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

        $Photos=Photo::where(['type'=>$id,'is_status'=>1])->orderBy('id', 'DESC')->get();
        $data=array();
        foreach($Photos as $pro) {
            $data_array=[
            'id'=>$pro->id, 
            'name'=>$pro->name,
            'photo'=>URL::to('/').'/uploads/photos/'.$pro->photo,
            ];
            array_push($data,$data_array);
        }

        if(empty($Photos)) {
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
                    'data'=>$data,
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