<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class ShowPhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        $Photo=Photo::where('type', $id)->first();
        if(empty($Photo)) {
            return response()->json(
                [
                    'errorCode'=>1,
                    'message'=>"Data null",
                    'status'=>401,
                ], 200
            );
        } else {
  
            if($Photo->photo!='') {
                $photo_detail=URL::to('/').'/uploads/photo/'.$Photo->photo;
            }
            else {
                $photo_detail='';
            }
            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>[
                        'photo'=>$photo_detail,
                        'link'=>$Photo->link,
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