<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use DN;

class SettingController extends Controller
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
        $id=1;
        $Setting=Setting::where('id', $id)->first();
        if(empty($Setting)) {
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
                    'data'=>$Setting,
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
       
        $data = $request->all();
        $id=1;
        $settingUpdate=Setting::where('id',$id)
        ->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'hotline'=>$request->hotline,
            'keywords'=>$request->keywords,
            'title'=>$request->title,
            'copyright'=>$request->copyright,
            'website'=>$request->website,
            'description'=>$request->description,
        ]);
        
         if($settingUpdate) {
            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>$settingUpdate,
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
        //
    }
}