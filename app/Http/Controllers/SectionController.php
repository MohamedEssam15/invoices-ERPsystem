<?php

namespace App\Http\Controllers;

use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Unique;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
{

$this->middleware('permission:المنتجات', ['only' => ['index']]);
$this->middleware('permission:اضافة قسم', ['only' => ['store']]);
$this->middleware('permission:تعديل قسم', ['only' => ['update']]);
$this->middleware('permission:حذف قسم', ['only' => ['destroy']]);

}

    public function index()
    {
        $sections = section::orderBy('id' , 'DESC')->get();
        return view("sections.section")->with('sections',$sections);
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
        $request->validate([
            'section_name' => ['required', 'string'],
        ],
        [
            'section_name.required' => 'برجاء كتابه اسم القسم'
        ]);
    $input=$request->all();
    $b_exists =section::where('section_name','=',$input["section_name"])->exists();
    if($b_exists){
        session()->flash("error","القسم مسجل مسبقا");
        return redirect()->back();
    }else{
        section::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'Created_by' => Auth::user()->name
        ]);
        session()->flash('Add',"تم اضافه القسم بنجاح");
    }
    return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {

        $sections = section::find( $request->id ) ;
        $request->validate([
            'section_name' => ['required', 'string'],
        ],
        [
            'section_name.required' => 'برجاء كتابه اسم القسم'

        ]);



    $sections->section_name = $request->section_name;
    $sections->description = $request->description;
    $sections->save();
    session()->flash('edit','تم تعديل القسم بنجاج');
    return redirect()->back() ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        section::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect()->back() ;
    }
}
