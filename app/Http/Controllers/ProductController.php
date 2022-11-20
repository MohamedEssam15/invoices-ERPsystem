<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
{

$this->middleware('permission:المنتجات', ['only' => ['index']]);
$this->middleware('permission:اضافة منتج', ['only' => ['store']]);
$this->middleware('permission:تعديل منتج', ['only' => ['update']]);
$this->middleware('permission:حذف منتج', ['only' => ['destroy']]);

}

    public function index()
    {
        $sections = section::all();
        $products=product::all();
        return view('products.product',compact('sections','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $request->validate([
            'product_name' => ['required', 'string'],
        ],
        [
            'product_name.required' => 'برجاء كتابه اسم المنتج'
        ]);
    $input=$request->all();
    $b_exists =product::where('product_name','=',$input["product_name"])
    ->where('section_id',$input["section_id"])->exists();
    if($b_exists){
        session()->flash("error","المنتج مسجل مسبقا");
        return redirect()->back();
    }else{
        product::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'section_id' => $request->section_id
        ]);
        session()->flash('Add',"تم اضافه المنتج بنجاح");
    }
    return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $id = section::where('section_name', $request->section_name)->first()->id;
        $products = product::find( $request->pro_id ) ;

        $request->validate([
            'Product_name' => ['required', 'string'],
        ],
        [
            'Product_name.required' => 'برجاء كتابه اسم المنتج'

        ]);



    $products->product_name = $request->Product_name;
    $products->description = $request->description;
    $products->section_id = $id;
    $products->save();
    session()->flash('edit','تم تعديل المنتج بنجاج');
    return redirect()->back() ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->pro_id;
        product::find($id)->delete();
        session()->flash('delete','تم حذف المنتج بنجاح');
        return redirect()->back() ;
    }
}
