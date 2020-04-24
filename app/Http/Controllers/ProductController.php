<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->id;
        $products = DB::table('products')
        ->join('categories','categories.id','products.category_id')
        ->select('products.*','categories.name')
        ->where('user_id','=', $user)
        ->orderBy('products.created_at','DESC')
        ->paginate(10);
        return response()->json($products);
    }

    public function id_user()
    {
        $user = Auth::user()->id;
        return response()->json($user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $product = Product::all();
        $this->validate($request, [
            'code' => 'required|string|max:10|unique:products',
            'nama' => 'required|string|max:100',
            'description' => 'nullable|string|max:100',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg'
        ]);

        // $potosaacana = $product->photo;
        // if($request->photo != $potosaacana){
        //     $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos
        //     ($request->photo, ';')))[1])[1];
        //     \Image::make($request->photo)->save(public_path('img/produk/').$name);
        //     $request->merge(['photo' => $name]);
        //     $photoProduk = public_path('img/produk/').$potosaacana;
        //     if(file_exists($photoProduk)){
        //         @unlink($photoProduk);
        //     }
        // }
    
     
        $product = Product::create([
            'code' => $request->code,
            'nama' => $request->nama,
            'description' => $request->description,
            'stock' => $request->stock,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'photo' => $request->photo
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        
        $this->validate($request,
        [
    
            'nama' => 'required|string',
            'description' => 'sometimes|nullable',
            'stock' => 'required|nullable',
            'photo' => 'sometimes|nullable',
            'price' => 'required|nullable',
            'category_id' => 'required|nullable',

        ]);
        
        $data->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
    }
}
