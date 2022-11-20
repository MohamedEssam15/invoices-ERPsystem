<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoice;
use App\Models\product;
use App\Models\section;
class Invoices_ReportController extends Controller
{
    public function index(){
        $products=product::all();
        $sections=section::all();
     return view('reports.invoices_report',compact('products','sections'));

    }

    public function Search_invoices(Request $request){
        $products=product::all();
        $sections=section::all();
    $radio = $request->radio;


 // في حالة البحث بنوع الفاتورة

    if ($radio == 1) {

    if(!empty($request->start_at)  || !empty($request->end_at) && !empty($request->section)){
    $start_at = date($request->start_at);
    $end_at = date($request->end_at);
    $type = $request->type;
    $sec=section::where('id','=',$request->section)->first();
    if ($request->type =='كل الفواتير') {
        $invoices = invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id','=',$request->section)->get();
    }else{
        $invoices = invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status','=',$request->type)->where('section_id','=',$request->section)->get();
        }
        return view('reports.invoices_report',compact('type','sec','start_at','end_at','products','sections'))->withDetails($invoices);
}
 // في حالة عدم تحديد تاريخ
        elseif ( $request->start_at =='' && $request->end_at =='' && $request->section =='' ) {
            if ($request->type =='كل الفواتير') {
           $invoices = invoice::select('*')->get();
            }else{
            $invoices = invoice::select('*')->where('Status','=',$request->type)->get();
            }
            $type = $request->type;
           return view('reports.invoices_report',compact('type','products','sections'))->withDetails($invoices);
        }

        // في حالة تحديد تاريخ استحقاق
        elseif(!empty($request->start_at)  || !empty($request->end_at) && empty($request->section)) {

          $start_at = date($request->start_at);
          $end_at = date($request->end_at);
          $type = $request->type;

            if ($request->type =='كل الفواتير') {
                $invoices = invoice::whereBetween('invoice_Date',[$start_at,$end_at])->get();
            }else{
                $invoices = invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status','=',$request->type)->get();
                }
          return view('reports.invoices_report',compact('type','start_at','end_at','products','sections'))->withDetails($invoices);
        }elseif(!empty($request->section)){
            $sec=section::where('id','=',$request->section)->first();


                if ($request->type =='كل الفواتير') {
                    $invoices = invoice::select('*')->where('section_id','=',$request->section)->get();
                }else{
                    $invoices = invoice::select('*')->where('Status','=',$request->type)->where('section_id','=',$request->section)->get();
                     }

                return view('reports.invoices_report',compact('sec','products','sections'))->withDetails($invoices);
        }



    }

//====================================================================

// في البحث برقم الفاتورة
    else {

        $invoices = invoice::select('*')->where('invoice_number','=',$request->invoice_number)->get();
        return view('reports.invoices_report',compact('products','sections'))->withDetails($invoices);

    }



    }

}
