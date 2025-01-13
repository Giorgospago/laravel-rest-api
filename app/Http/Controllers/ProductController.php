<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Str;

class ProductController extends Controller
{
    public function index()
    {
        // SELECT * FROM products
        $products = Product::with("category")->get();

        // $products = Product::all();
        // $products->load("category");

        return response()->json([
            "message" => "List of products",
            "products" => $products
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'category_id' => 'filled|exists:categories,id',
            'description' => 'max:255',
            'price' => 'required|decimal:0,2|max:99999999.99|min:0.01',
            'image' => 'url:http,https'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                "message" => "Validation failed",
                "errors" => $validator->errors()
            ], 400);
        }

        $slug = str()->slug($request->title);
        $existedProduct = Product::where("slug", $slug)->first();

        if ($existedProduct) {
            return response()->json([
                "message" => "Validation failed",
                "errors" => [
                    "slug" => ["Slug already existed"]
                ]
            ], 400);
        }

        $product = Product::create([
            "title"=> $request->title,
            "category_id"=> $request->category_id,
            "description"=> $request->description,
            "price"=> $request->price,
            "image"=> $request->image,
            "slug"=> $slug
        ]);

        return response()->json([
            "message" => "Product created",
            "product" => $product
        ], 201);
    }

    public function show($id)
    {
        // Method 1
        // $product = Product::find($id);
        // $product->load("category");

        // Method 2
        // $product = Product::with("category")->find($id);

        // Method 3
        $product = Product::with("category")
            ->where("id", $id)
            ->first();

        if ($product === null) {
            return response()->json([
                "message" => "Product not found"
            ], 404);
        }

        return response()->json([
            "message" => "Product found",
            "product"=> $product
        ]);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product === null) {
            return response()->json([
                "message" => "Product not found"
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'filled|max:255',
            'category_id' => 'filled|exists:categories,id',
            'description' => 'max:255',
            'price' => 'decimal:0,2|max:99999999.99|min:0.01',
            'image' => 'url:http,https',
            'slug' => ['filled', Rule::unique('products', 'slug')->ignore($id)]
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Validation failed",
                "errors" => $validator->errors()
            ], 400);
        }

        $product->update($request->all());

        return response()->json([
            "message"=> "Product with id: $id updated"
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product === null) {
            return response()->json([
                "message" => "Product not found"
            ], 404);
        }

        $product->delete();

        return response()->json([
            "message"=> "Product with id: $id deleted"
        ]);
    }
}
