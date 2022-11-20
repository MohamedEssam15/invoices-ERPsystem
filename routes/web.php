<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
define("controller_root","App\Http\Controllers\\");
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Redirect("home");
});
Route::get('/signin', function(){
    return view("auth.signin");
});
Route::get('/login', function(){
    return view("auth.signin");
})->name("login");
Route::get('/signup', function(){
  return view("auth.signup");
});
Route::post("/signup",controller_root.'AuthController@signup')->name("signup");
Route::post("/signin",controller_root.'AuthController@signin')->name("signin");

Route::get('/logout', function(){
    Auth::logout();
    return redirect()->route('signin');
 })->name('logout');

 Route::get('/home', function () {
    return view('home');
})->middleware("auth");
Route::group(['middleware' => ['auth']], function() {

    Route::resource('roles',controller_root.'RoleController');

    Route::resource('users',controller_root.'UserController');

    });
Route::group(['middleware' => ['auth']], function() {
Route::get('/home',controller_root.'HomeController@index')->name('home');
Route::resource("/invoices",controller_root.'InvoiceController');
Route::resource("section",controller_root.'SectionController');
Route::resource("products",controller_root.'ProductController');
Route::get("sections/{id}",controller_root.'InvoiceController@getproducts');
Route::get("invoicesedit/{id}",controller_root.'InvoiceController@edit');
Route::get("InvoicesDetails/{id}",controller_root.'InvoicesDetailsController@edit');
Route::resource("/InvoiceAttachments",controller_root.'InvoiceAttachmentsController');
Route::post('delete_file', controller_root.'InvoicesDetailsController@destroy')->name('delete_file');
Route::delete('invoices.delete', controller_root.'InvoiceController@destroy')->name('invoices.delete');
Route::get('/Status_show/{id}', controller_root.'InvoiceController@show')->name('Status_show');
Route::post('/Status_Update/{id}',controller_root.'InvoiceController@Status_Update')->name('Status_Update');
Route::resource('/Archive', controller_root.'ArchiveController');
Route::get('Invoice_Paid',controller_root.'InvoiceController@Invoice_Paid')->name('Invoice_Paid');
Route::get('Invoice_UnPaid',controller_root.'InvoiceController@Invoice_UnPaid')->name('Invoice_UnPaid');
Route::get('Invoice_Partial',controller_root.'InvoiceController@Invoice_Partial')->name('Invoice_Partial');
Route::get('Print_invoice/{id}',controller_root.'InvoiceController@Print_invoice');
Route::get('invoices_report', controller_root.'Invoices_ReportController@index');
Route::post('Search_invoices',controller_root.'Invoices_ReportController@Search_invoices');
Route::get('MarkAsRead_all',controller_root.'InvoiceController@MarkAsRead_all')->name('MarkAsRead_all');
Route::get('unreadNotifications_count',controller_root.'InvoiceController@unreadNotifications_count')->name('unreadNotifications_count');
Route::get('unreadNotifications',controller_root.'InvoiceController@unreadNotifications')->name('unreadNotifications');
Route::get('/{page}', controller_root.'AdminController@index');
    });
