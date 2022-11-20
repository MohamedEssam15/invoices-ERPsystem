@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">فواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ معلومات حول الفاتوره</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <!-- div -->
            @if (session()->has('delete'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('delete') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session()->has('Add'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('Add') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
            <div class="card" id="tabs-style4">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        رقم الفاتوره: {{$invoice->invoice_number}}
                    </div>
                    <div class="text-wrap">
                        <div class="example">
                            <div class="d-md-flex">
                                <div class="">
                                    <div class="panel panel-primary tabs-style-4">
                                        <div class="tab-menu-heading">
                                            <div class="tabs-menu ">
                                                <!-- Tabs -->
                                                <ul class="nav panel-tabs ml-3">
                                                    <li class=""><a href="#tab21" class="active" data-toggle="tab"><i
                                                                class="fa fa-laptop"></i> معلومات</a></li>
                                                    <li><a href="#tab22" data-toggle="tab"><i class="fa fa-cube"></i> حاله الدفع</a></li>
                                                    <li><a href="#tab23" data-toggle="tab"><i class="fa fa-cogs"></i> مرفقات</a></li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tabs-style-4 ">
                                    <div class="panel-body tabs-menu-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab21">
                                                <p>المنتج : {{$detail->product}}</p>
                                                <p>القسم : {{$invoice->section->section_name}}</p>
                                                <p>ملاحظات : {{$detail->note}}</p>
                                                <p>اضيفت بواسطه : {{$detail->user}}</p>
                                                <p class="mb-0">تاريخ الاضافه : {{$details->first()->created_at->format('Y-m-d')}}</p>
                                            </div>
                                            <div class="tab-pane" id="tab22">
                                                <p>حاله الدفع الحاليه : @if ($detail->Value_Status == 1)
                                                    <span class="text-success">{{ $detail->Status }}</span>
                                                @elseif($detail->Value_Status == 2)
                                                    <span class="text-danger">{{ $detail->Status }}</span>
                                                @else
                                                    <span class="text-warning">{{ $detail->Status }}</span>
                                                @endif</p>
                                                <div class="col-xl-12">
                                                    <div class="card">
                                                        <div class="card-header pb-0">
                                                            <div class="d-flex justify-content-between">
                                                                <h4 class="card-title mg-b-0">سجل الدفع</h4>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover mb-0 text-md-nowrap">
                                                                    @php
                                                                        $i=1;
                                                                    @endphp
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>تاريخ الفاتوره</th>
                                                                            <th>تاريخ الاستتحقاق</th>
                                                                            <th>القسم</th>
                                                                            <th>الحاله</th>
                                                                            <th>تاريخ الدفع</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ( $details as $detailss )


                                                                        <tr>
                                                                            <th scope="row">{{$i++}}</th>
                                                                            <td>{{$details->first()->created_at->format('Y-m-d')}}</td>
                                                                            <td>{{$invoice->Due_date}}</td>
                                                                            <td>{{$invoice->section->section_name}}</td>
                                                                            <td>@if ($detailss->Value_Status == 1)
                                                                                <span class="text-success">{{ $detailss->Status }}</span>
                                                                            @elseif($detailss->Value_Status == 2)
                                                                                <span class="text-danger">{{ $detailss->Status }}</span>
                                                                            @else
                                                                                <span class="text-warning">{{ $detailss->Status }}</span>
                                                                            @endif</td>
                                                                            <td>{{$detailss->Payment_Date}}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab23">
                                                {{-- <p>المرفق : @if ($attach !=null)
                                                    <a class="btn btn-outline-success btn-sm"
                                                    href="{{ url('Attachments') }}/{{ $attach->invoice_number }}/{{ $attach->file_name }}"
                                                    role="button"><i class="fas fa-eye"></i>&nbsp;
                                                    عرض</a>
                                                    @else
                                                    <span class="text-danger">{{"لا يوجد مرفقات"}}</span>

                                                @endif</p>
                                                <p></p>
                                                <p class="mb-0"></p> --}}
                                                <div class="card card-statistics">
                                                    @can('اضافة مرفق')
                                                        <div class="card-body">
                                                            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                            <h5 class="card-title">اضافة مرفقات</h5>
                                                            <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                                                enctype="multipart/form-data">
                                                                {{ csrf_field() }}
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" id="customFile"
                                                                        name="file_name" required>
                                                                    <input type="hidden" id="customFile" name="invoice_number"
                                                                        value="{{ $invoice->invoice_number }}">
                                                                    <input type="hidden" id="invoice_id" name="invoice_id"
                                                                        value="{{ $invoice->id }}">
                                                                    <label class="custom-file-label" for="customFile">حدد
                                                                        المرفق</label>
                                                                </div><br><br>
                                                                <button type="submit" class="btn btn-primary btn-sm "
                                                                    name="uploadedFile">تاكيد</button>
                                                            </form>
                                                        </div>
                                                    @endcan
                                                    <br>

                                                    <div class="table-responsive mt-15">
                                                        <table class="table center-aligned-table mb-0 table table-hover"
                                                            style="text-align:center">
                                                            <thead>
                                                                <tr class="text-dark">
                                                                    <th scope="col">م</th>
                                                                    <th scope="col">اسم الملف</th>
                                                                    <th scope="col">قام بالاضافة</th>
                                                                    <th scope="col">تاريخ الاضافة</th>
                                                                    <th scope="col">العمليات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $i = 0; ?>
                                                                @foreach ($attach as $attachment)
                                                                    <?php $i++; ?>
                                                                    <tr>
                                                                        <td>{{ $i }}</td>
                                                                        <td>{{ $attachment->file_name }}</td>
                                                                        <td>{{ $attachment->Created_by }}</td>
                                                                        <td>{{ $attachment->created_at }}</td>
                                                                        <td colspan="2">

                                                                            <a class="btn btn-outline-success btn-sm"
                                                                                href="{{ url('Attachments') }}/{{ $invoice->invoice_number }}/{{ $attachment->file_name }}"
                                                                                role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                                عرض</a>
                                                                                @can('حذف المرفق')
                                                                                <button class="btn btn-outline-danger btn-sm"
                                                                                    data-toggle="modal"
                                                                                    data-file_name="{{ $attachment->file_name }}"
                                                                                    data-invoice_number="{{ $attachment->invoice_number }}"
                                                                                    data-id_file="{{ $attachment->id }}"
                                                                                    data-target="#delete_file">حذف</button>
                                                                                    @endcan

                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('delete_file') }}" method="post">

                                    {{ csrf_field() }}
                                    <div class="modal-body">
                                        <p class="text-center">
                                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                                        </p>

                                        <input type="hidden" name="id_file" id="id_file" value="">
                                        <input type="hidden" name="file_name" id="file_name" value="">
                                        <input type="hidden" name="invoice_number" id="invoice_number" value="">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                                        <button type="submit" class="btn btn-danger">تاكيد</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
                <!-- /div -->
            </div>
        </div>
    </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
<script>
    $('#delete_file').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id_file = button.data('id_file')
        var file_name = button.data('file_name')
        var invoice_number = button.data('invoice_number')
        var modal = $(this)
        modal.find('.modal-body #id_file').val(id_file);
        modal.find('.modal-body #file_name').val(file_name);
        modal.find('.modal-body #invoice_number').val(invoice_number);
    })
</script>

<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>

@endsection
