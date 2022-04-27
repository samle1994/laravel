<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
class PhotoStaticController extends Controller
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
       
        $PhotoDetail=Photo::where('type', $id)->first();

        if(empty($PhotoDetail)) {
  
        if($request->hasfile('photo')) 
        { 
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename =time().'.'.$extension;
            $file->move('uploads/photo/', $filename);
            
        } else {
            $filename='';
        }
        $Photo=Photo::create([
            'link' => $request->name,
            'photo' => $filename,
            'type' => $id,
        ]
        );
         
        if(!empty($Photo)) {
            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>$Photo,
                    'status'=>200,
                ], 200
            );
        } else {
            return response()->json(
                [
                    'errorCode'=>1,
                    'message'=>'Có lỗi xảy ra',
                    'status'=>401
                    
                ], 201
            );
        }
        } else {
            $PhotoUpdate=Photo::where('type',$id)
            ->update([
                'link' => $request->link,
            ]);
    
            if($request->hasfile('photo')) 
            { 
                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                $file->move('uploads/photo/', $filename);
                Photo::where('type',$id)
                ->update([
                    'photo' => $filename,
                ]);
                @unlink('uploads/photo/'.$PhotoDetail['photo']);
            }  
            
            if($PhotoUpdate) {
                return response()->json(
                    [
                        'errorCode'=>0,
                        'data'=>$PhotoUpdate,
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