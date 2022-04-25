<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Gallery;
use App\Models\SessionUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
        $searchTerm= $request->input('keyword');
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $searchTerm = str_replace($reservedSymbols, ' ', $searchTerm);

        $searchValues = preg_split('/\s+/', $searchTerm, -1, PREG_SPLIT_NO_EMPTY);

        $page= $request->input('page');
        $pageLength= $request->input('pageLength');
        $product_cat=Products::with('productList')->where(function ($q) use ($searchValues) {
            foreach ($searchValues as $value) {
            $q->orWhere('name', 'like', "%{$value}%");
            }
        })->offset($page*$pageLength)->take($pageLength)->get();
        $pageInfo=DB::table('product')->where(function ($q) use ($searchValues) {
            foreach ($searchValues as $value) {
            $q->orWhere('name', 'like', "%{$value}%");
            }
        })->paginate($pageLength);
        //dd($pageInfo);
        return response()->json(
            [
                'errorCode'=>0,
                'data'=>$product_cat,
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
        $file->move('uploads/product/', $filename);
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
            $product=Products::create([
                'name' => $request->name,
                'type' => 'product',
                'id_list' => $request->id_list,
                'id_cat' => $request->id_cat,
                'photo' => $filename,
                'price' => $request->price,
                'description' => $request->description,
                'content' => $request->content,
                'slug' => $request->slug
            ]
            );

            if($request->hasFile('files'))
            {
                $filename='';
                $files=$request->file('files');
                $dataFile=array();
                foreach($files as $image)
                {
                    $destinationPath = 'uploads/gallery/';   
                    $extension = $image->getClientOriginalExtension(); // getting image extension
                    $filename =time().'.'.$extension;
                    $image->move($destinationPath, $filename);
                    $data=[
                        'type' => 'product',
                        'id_list' => $product['id'],
                        'photo' => $filename
                    ];
                    array_push($dataFile,$data);
                }  
                $Gallery=Gallery::insert($dataFile);
            }

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
 
        $value= $request->input('value');
        $type= $request->input('type');
     
        if($value!='' && $type!='') {

            $productUpdate=Products::where('id',$id)
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

                if($request->hasfile('photo')) 
                { 
                $file = $request->file('photo');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                $file->move('uploads/product/', $filename);
                } else {
                    $filename='';
                }
                
                $request->slug= Str::slug($request->name , "-");
             
                $productUpdate=Products::where('id',$id)
                ->update([
                    'name' => $request->name,
                    'id_list' => $request->id_list,
                    'id_cat' => $request->id_cat,
                    'photo' => $filename,
                    'price' => $request->price,
                    'description' => $request->description,
                    'content' => $request->content,
                    'slug' => $request->slug
                ]);

                if($request->hasFile('files'))
                {
                    $filename='';
                    $files=$request->file('files');
                    $dataFile=array();
                    foreach($files as $image)
                    {
                        $destinationPath = 'uploads/gallery/';   
                        $extension = $image->getClientOriginalExtension(); // getting image extension
                        $filename =time().'.'.$extension;
                        $image->move($destinationPath, $filename);
                        $data=[
                            'type' => 'product',
                            'id_list' => $id,
                            'photo' => $filename
                        ];
                        array_push($dataFile,$data);
                    }  
                    $Gallery=Gallery::insert($dataFile);
                }
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