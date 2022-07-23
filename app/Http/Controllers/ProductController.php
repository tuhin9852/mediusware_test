<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {

        $data = Product::join('product_variant_prices', 'product_variant_prices.product_id','products.id') ->join('product_variants AS t', 't.id', 'product_variant_prices.product_variant_one') ->join('product_variants AS e', 'e.id', 'product_variant_prices.product_variant_two')->join('product_variants AS f', 'f.id', 'product_variant_prices.product_variant_two')->select('products.*', 'product_variant_prices.*','t.variant AS one','e.variant AS two','f.variant AS three')->get();
        // $data = $data->groupBy('product_id');
        $products = Product::paginate(5);

        foreach($products as $product){

            $data[$product->id] = $data->where('product_id', '=', $product->id);

        }

        $pVariants = ProductVariant::join('variants','variants.id','product_variants.variant_id')->get();
        $pVariants= $pVariants->groupBy('title');
        // return $pVariants;

        return view('products.index')->with(compact('data','products', 'pVariants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
