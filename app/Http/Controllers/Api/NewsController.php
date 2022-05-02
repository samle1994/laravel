<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\SessionUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use DB;
class NewsController extends Controller
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
        $News=News::where(function ($q) use ($searchValues) {
            foreach ($searchValues as $value) {
            $q->orWhere('name', 'like', "%{$value}%");
            }
        })->orderBy('id', 'DESC')->offset($page*$pageLength)->take($pageLength)->get();
        $pageInfo=DB::table('news')->where(function ($q) use ($searchValues) {
            foreach ($searchValues as $value) {
            $q->orWhere('name', 'like', "%{$value}%");
            }
        })->paginate($pageLength);
        
        $data=array();
        foreach($News as $pro) {
            
            $data_array=[
            'id'=>$pro->id, 
            'name'=>$pro->name,
            'is_status'=>$pro->is_status,
            'hot'=>$pro->hot,
            'photo'=>URL::to('/').'/uploads/news/'.$pro->photo,
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

        if($request->hasfile('photo')) 
        { 
        $file = $request->file('photo');
        $extension = $file->getClientOriginalExtension(); // getting image extension
        $filename =time().'.'.$extension;
        $file->move('uploads/news/', $filename);
        } else {
            $filename='';
        }

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
            //dd($request);
            $News=News::create([
                'name' => $request->name,
                'type' => 'news',
                'photo' => $filename,
                'description' => $request->description,
                'content' => $request->content,
                'slug' => $request->slug
            ]
            );
         
        if(!empty($News)) {
            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>$News,
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
        $newsDetail=News::where('id', $id)->first();
        if(empty($newsDetail)) {
            return response()->json(
                [
                    'errorCode'=>1,
                    'message'=>"Data null",
                    'status'=>401,
                ], 200
            );
        } else {
  
            if($newsDetail->photo!='') {
                $photo_detail=URL::to('/').'/uploads/news/'.$newsDetail->photo;
            }
            else {
                $photo_detail='';
            }
            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>[
                        'id'=>$newsDetail->id, 
                        'name'=>$newsDetail->name,
                        'photo'=>$photo_detail,
                        'content'=>$newsDetail->content,
                        'description'=>$newsDetail->description,
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

            $newsUpdate=News::where('id',$id)
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
             
                $newsUpdate=News::where('id',$id)
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'content' => $request->content,
                    'slug' => $request->slug
                ]);

                if($request->hasfile('photo')) 
                { 
                    $file = $request->file('photo');
                    $extension = $file->getClientOriginalExtension(); // getting image extension
                    $filename =time().'.'.$extension;
                    $file->move('uploads/news/', $filename);

                    News::where('id',$id)
                    ->update([
                        'photo' => $filename,
                    ]);
                    //dd($productUpdate);
                }    
         }
         if($newsUpdate) {
            return response()->json(
                [
                    'errorCode'=>0,
                    'data'=>$newsUpdate,
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
        $deleted_detail = News::where('id', $id)->first();
        $deleted = News::where('id', $id)->delete();

        @unlink('uploads/news/'.$deleted_detail['photo']);
    
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