<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
class HitungController extends Controller
{
	public function index()
	{
    $hitung = User::where('status','=','0')->count();
    return response()->json($hitung);
	}

	public function stok()
	{
	$id = auth()->user()->id;	
    $product = Product::where('user_id','=', $id)->count();
    return response()->json($product);
	}
}
