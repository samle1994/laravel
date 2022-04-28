<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\SessionUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use DB;
class PhotoController extends Controller
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
        $type= $request->input('type');
        $News=Photo::where(function ($q) use ($searchValues) {
            foreach ($searchValues as $value) {
            $q->orWhere('name', 'like', "%{$value}%");
            }
        })->where('type',$type)->orderBy('id', 'DESC')->offset($page*$pageLength)->take($pageLength)->get();
        $pageInfo=DB::table('photo')->where(function ($q) use ($searchValues) {
            foreach ($searchValues as $value) {
            $q->orWhere('name', 'like', "%{$value}%");
            }
        })->where('type',$type)->paginate($pageLength);
        
        $data=array();
        foreach($News as $pro) {
            
            $data_array=[
            'id'=>$pro->id, 
            'name'=>$pro->name,
            'is_status'=>$pro->is_status,
            'photo'=>URL::to('/').'/uploads/photos/'.$pro->photo,
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
        $data = $request->all();
        $type= $request->input('type');
        if($request->hasfile('photo')) 
        { 
        $file = $request->file('photo');
        $extension = $file->getClientOriginalExtension(); // getting image extension
        $filename =time().'.'.$extension;
        $file->move('uploads/photos/', $filename);
        } else {
            $filename='';
        }
            //dd($request);
            $Photo=Photo::create([
                'name' => $request->name,
                'type' => $type,
                'photo' => $filename,
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Photodetail=Photo::where('id', $id)->first();
        if(empty($Photodetail)) {
            return response()->json(
                [
                    'errorCode'=>1,
                    'message'=>"Data null",
                    'status'=>401,
                ], 200
            );
        } else {
  
            if($Photodetail->photo!='') {
                $photo_detail=URL::to('/').'/uploads/photos/'.$Photodetail->photo;
            }
            else {
                $photo_detail='';
            }
            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>[
                        'id'=>$Photodetail->id, 
                        'name'=>$Photodetail->name,
                        'photo'=>$photo_detail
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
        $value= $request->input('value');
        $type= $request->input('type');
     
        if($value!='' && $type!='') {

            $photoUpdate=Photo::where('id',$id)
            ->update([
                $type => $value
            ]);
        
        } else {
            
                $data = $request->all();

                $photoUpdate=Photo::where('id',$id)
                ->update([
                    'name' => $request->name,
                ]);

                if($request->hasfile('photo')) 
                { 
                    $file = $request->file('photo');
                    $extension = $file->getClientOriginalExtension(); // getting image extension
                    $filename =time().'.'.$extension;
                    $file->move('uploads/photos/', $filename);
                    Photo::where('id',$id)
                    ->update([
                        'photo' => $filename,
                    ]);
                    //dd($productUpdate);
                }    
         }
         if($photoUpdate) {
            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>$photoUpdate,
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
        $deleted_detail = Photo::where('id', $id)->first();
        $deleted = Photo::where('id', $id)->delete();

        @unlink('uploads/photos/'.$deleted_detail['photo']);
    
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