<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Yajra\DataTables\DataTables;


class ProductController extends Controller
{
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sku' => 'required|string',
            'product_name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        Product::create($request->all());
        Product::create($validatedData);

        return redirect()->route('products.create')->with('success', 'Product added successfully!');
        // return redirect()->route('products.index')->with('success', 'Product added successfully');
    }

    public function index()
{
    if (request()->ajax()) {
        $products = Product::all();
        
        return DataTables::of($products)
        ->addColumn('action', function($row){
            $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
            $btn .= ' <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
            return $btn;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    return view('products.index');
}

public function edit(Product $product)
{
    return view('products.edit', compact('product'));
}

public function update(Request $request, Product $product)
{
    $request->validate([
        'sku' => 'required|string',
        'product_name' => 'required|string',
        'description' => 'required|string',
        'price' => 'required|numeric',
    ]);

    $product->update($request->all());

    return redirect()->route('products.index')->with('success', 'Product updated successfully');
}

public function destroy(Product $product)
{
    $product->delete();
    return redirect()->route('products.index')->with('success', 'Product deleted successfully');
}



}



abstract class Controller
{
    //
}


// 'upc' => 'required|string',
//             'mpn' => 'required|string',
//             'brand' => 'required|string',

// 'upc' => 'required|string',
//         'mpn' => 'required|string',
//         'brand' => 'required|string',