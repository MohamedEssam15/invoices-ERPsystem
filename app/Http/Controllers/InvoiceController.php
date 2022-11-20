<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Notification;
use App\Models\invoice;
use App\Models\User;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
{

$this->middleware('permission:قائمة الفواتير', ['only' => ['index']]);
$this->middleware('permission:الفواتير المدفوعة', ['only' => ['Invoice_Paid']]);
$this->middleware('permission:الفواتير المدفوعة جزئيا', ['only' => ['Invoice_partial']]);
$this->middleware('permission:الفواتير الغير مدفوعة', ['only' => ['Invoice_unPaid']]);
$this->middleware('permission:اضافة فاتورة', ['only' => ['create','store']]);
$this->middleware('permission:تعديل الفاتورة', ['only' => ['edit','update']]);
$this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
$this->middleware('permission:قائمة الفواتير', ['only' => ['show']]);
$this->middleware('permission:تغير حالة الدفع', ['only' => ['Status_Update']]);
$this->middleware('permission:طباعةالفاتورة', ['only' => ['Print_invoice']]);
}

    public function index()
    {
        $invoices=invoice::all();
        return view("invoices.all_invoices",compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = section::all();
        return view("invoices.add_invoices",compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);

        $invoice_id = invoice::latest()->first()->id;
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoice::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }
        $type=1;
        $user = User::get();
        $invoices = invoice::latest()->first();
        Notification::send($user, new \App\Notifications\Add_invoice($invoices,$type));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = invoice::where('id', $id)->first();
        return view('invoices.status_update', compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice=invoice::where('id',$id)->first();
        $sections = section::all();
        return view('invoices.edit_invoices',compact('sections','invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $invoice = invoice::findOrFail( $request->invoice_id ) ;
        $this->validate($request,[
            "invoice_id" => "required",
            "invoice_number" => "required",
            "invoice_Date" => "required",
            "Due_date" => "required",
            "Section" => "required",
            "product" => "required",
            "Amount_collection" => "required",
            "Amount_Commission" => "required",
            "Discount" => "required",
            "Rate_VAT" => "required",
            "Value_VAT" => "required",
            "Total" => "required",
        ]);
     //save update in invoice table
     $invoice->invoice_number = $request->invoice_number;
     $invoice->invoice_Date = $request->invoice_Date;
     $invoice->Due_date = $request->Due_date;
     $invoice->section_id = $request->Section;
     $invoice->product = $request->product;
     $invoice->Amount_collection = $request->Amount_collection;
     $invoice->Discount = $request->Discount;
     $invoice->Rate_VAT = $request->Rate_VAT;
     $invoice->Value_VAT = $request->Value_VAT;
     $invoice->Total = $request->Total;
     $invoice->save();

     //save update in invoicesDetails table
     $invoices=invoices_details::where('id_Invoice',$request->invoice_id)->first();
     $invoices->invoice_number = $request->invoice_number;
     $invoices->product = $request->product;
     $invoices->Section = $request->Section;
     $invoices->note = $request->note;
     $invoices->save();

     //save update in invoiceAttachments table
     $attachments=invoice_attachments::where('invoice_id',$request->invoice_id)->get();
     $att=invoice_attachments::where('invoice_id',$request->invoice_id)->first();
     $path=public_path('Attachments/' . $request->invoice_number);
     $pathold=public_path('Attachments/' . $att->invoice_number);
     if($path != $pathold){
     foreach($attachments as $attach){
        if($request->invoice_number != $attach->invoice_number){
        $path=public_path('Attachments/' . $request->invoice_number);
        $pathold=public_path('Attachments/' . $attach->invoice_number);
        if(!File::exists($path)) {
            File::makeDirectory($path);
        }
        File::move($pathold.'/'.$attach->file_name,$path.'/'.$attach->file_name );

        $attach->invoice_number = $request->invoice_number;
        $attach->save();
    }

    }

        if(File::exists($pathold)) {
            File::deleteDirectory($pathold);
        }
    }
    $type=3;
        $user = User::get();
        $invoices = invoice::latest()->first();
        Notification::send($user, new \App\Notifications\Add_invoice($invoices,$type));
    session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
    return redirect()->back() ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoice::where('id', $id)->first();
        $Details = invoice_attachments::where('invoice_id', $id)->first();

         $id_page =$request->id_page;

        if (!$id_page==2) {

        if (!empty($Details->invoice_number)) {

            File::deleteDirectory(public_path('Attachments/' . $Details->invoice_number));
        }

        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/invoices');

        }elseif($id_page==3){
            if (!empty($Details->invoice_number)) {

                File::deleteDirectory(public_path('Attachments/' . $Details->invoice_number));
            }

         $invoices = invoice::withTrashed()->where('id',$request->invoice_id)->first();
         $invoices->forceDelete();
         session()->flash('delete_invoice');
         return redirect('/Archive');
        }else {
            $type=2;
            $user = User::get();
            $invoices = invoice::latest()->first();
            Notification::send($user, new \App\Notifications\Add_invoice($invoices,$type));
            $invoices->delete();
            session()->flash('archive_invoice');
            return redirect('/Archive');
        }

    }
    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }
    public function Status_Update($id, Request $request)
    {
        $invoices = invoice::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        $type=4;
        $user = User::get();
        $invoices;
        Notification::send($user, new \App\Notifications\Add_invoice($invoices,$type));
        }

        else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
            $type=5;
        $user = User::get();

        Notification::send($user, new \App\Notifications\Add_invoice($invoices,$type));
        }
        session()->flash('Status_Update');
        return redirect('/invoices');

    }
    public function Invoice_Paid()
    {
        $invoices = Invoice::where('Value_Status', 1)->get();
        return view('invoices.paid',compact('invoices'));
    }

    public function Invoice_unPaid()
    {
        $invoices = Invoice::where('Value_Status',2)->get();
        return view('invoices.unpaid',compact('invoices'));
    }

    public function Invoice_Partial()
    {
        $invoices = Invoice::where('Value_Status',3)->get();
        return view('invoices.partial',compact('invoices'));
    }
    public function Print_invoice($id)
    {
        $invoices = invoice::where('id', $id)->first();
        return view('invoices.Print_invoice',compact('invoices'));
    }
    public function MarkAsRead_all (Request $request)
    {

        $userUnreadNotification= auth()->user()->unreadNotifications;

        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }


    }


    public function unreadNotifications_count()

    {
        return auth()->user()->unreadNotifications->count();
    }

    public function unreadNotifications()

    {
        foreach (auth()->user()->unreadNotifications as $notification){

return $notification->data['title'];

        }

    }

}
