<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response(['data'=>$products]);
    }

    public function show(Product $product)
    {
        $product -> category;
        return response(['data' => $product ]);
    }

    public function searchByCategory(Category $category)
    {
        $product = $category -> product;
        return response(['data'=> $product]);
    }
}
