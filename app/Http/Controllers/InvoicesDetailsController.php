<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachments;
use App\Models\invoices_details;
use Illuminate\Http\Request;
use App\Models\invoice;
use Illuminate\Support\Facades\File;



class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
{
$this->middleware('permission:قائمة الفواتير', ['only' => ['edit']]);
$this->middleware('permission:حذف المرفق', ['only' => ['destroy']]);

}

    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices_detalis  $invoices_detalis
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_details $invoices_detalis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_detalis  $invoices_detalis
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $details=invoices_details::where('id_Invoice', $id)->get();
        $detail=invoices_details::where('id_Invoice', $id)->latest()->first();

        $invoice=invoice::where('id', $id)->first();
        $attach=invoice_attachments::where('invoice_id',$id)->get();
        return view('invoices.invoices_details',compact('details','attach','invoice','detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_detalis  $invoices_detalis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_details $invoices_detalis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_detalis  $invoices_detalis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $invoices = invoice_attachments::findOrFail($request->id_file);
        $invoices->delete();
        File::delete(public_path('Attachments/').$request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

}
