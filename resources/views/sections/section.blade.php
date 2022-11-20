@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الاقسام</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
                    @if ($errors->any())
                    @foreach ( $errors->all() as $error )
                    <div class="alert alert-outline-danger mg-b-0" role="alert">
                        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span></button>
                        <strong>{{$error}}</strong>
                    </div>
                    @endforeach
                    @endif
                    @if (session()->has("error"))
                    <div class="alert alert-outline-warning" role="alert">
                        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span></button>
                        <strong>{{session()->get("error")}}</strong>
                    </div>
                    @endif
                    @if (session()->has("delete"))
                    <div class="alert alert-outline-warning" role="alert">
                        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span></button>
                        <strong>{{session()->get("delete")}}</strong>
                    </div>
                    @endif
                    @if (session()->has("Add"))
                    <div class="alert alert-outline-success" role="alert">
                        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span></button>
                        <strong>{{session()->get("Add")}}</strong>
                    </div>
                    @endif
                    <div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									@can('اضافة قسم')
                                    <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-flip-vertical" data-toggle="modal" href="#modaldemo8">اضافه قسم</a>
                                    </div>
                                    @endcan
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-hover mb-0 text-md-nowrap">
										<thead>
											<tr>
												<th>#</th>
												<th>الاسم</th>
												<th>الوصف</th>
                                                <th>اسم المستخدم</th>
                                                <th>تاريخ الانشاء</th>
												<th>العمليات</th>
											</tr>
										</thead>
										<tbody>
					@php
                        $i = 1;

                    @endphp
                    @foreach ($sections as $item)
                    <tr>
                        <th scope="row">{{$i++}}</th>
                        <td>{{$item->section_name}}</td>
                        <td>{{$item->description}}</td>
                        <td>{{$item->Created_by}}</td>
                        <td>{{$item->created_at->format("Y-m-d")}}</td>
                        <td>
                            @can('تعديل قسم')
                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                data-id="{{ $item->id }}" data-section_name="{{ $item->section_name }}"
                                data-description="{{ $item->description }}" data-toggle="modal" href="#exampleModal2"
                                title="تعديل"><i class="las la-pen"></i></a>
                                @endcan
                                @can('حذف قسم')
                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                data-id="{{ $item->id }}" data-section_name="{{ $item->section_name }}" data-toggle="modal"
                                href="#modaldemo9" title="حذف"><i class="las la-trash"></i></a>
                                @endcan
                            </td>
                      </tr>
                    @endforeach
										</tbody>
									</table>
								</div>
							</div>
                            <div class="modal" id="modaldemo8">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content modal-content-demo">
                                    <form method="post" action="{{route("section.store")}}">
                                       @csrf
                                        <div class="modal-header">
                                            <h6 class="modal-title">اضافه قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                                                    <!--div-->
                                                    <div class="card">


                                                        <div class="card-body">
                                                            <div class="row row-sm">
                                                                <div class="col-lg">
                                                                    <label>اسم القسم</label>
                                                                    <input class="form-control" placeholder="اسم القسم" name="section_name" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="row row-sm mg-t-20">
                                                                <div class="col-lg">
                                                                    <label>الوصف</label>
                                                                    <textarea class="form-control" placeholder="الوصف" name="description" rows="4"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn ripple btn-primary" type="submit">حفظ</button>
                                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلق</button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div>
                <!-- edit -->
                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
               <div class="modal-dialog" role="document">
                   <div class="modal-content">
                       <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">تعديل القسم</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                               <span aria-hidden="true">&times;</span>
                           </button>
                       </div>
                       <div class="modal-body">

                           <form action="section/update" method="post" autocomplete="off">
                               {{method_field('patch')}}
                               {{csrf_field()}}
                               <div class="form-group">
                                   <input type="hidden" name="id" id="id" value="">
                                   <label for="recipient-name" class="col-form-label">اسم القسم:</label>
                                   <input class="form-control" name="section_name" id="section_name" type="text">
                               </div>
                               <div class="form-group">
                                   <label for="message-text" class="col-form-label">ملاحظات:</label>
                                   <textarea class="form-control" id="description" name="description"></textarea>
                               </div>
                       </div>
                       <div class="modal-footer">
                           <button type="submit" class="btn btn-primary">تاكيد</button>
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                       </div>
                       </form>
                   </div>
               </div>
           </div>

       <!-- delete -->
       <div class="modal" id="modaldemo9">
           <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content modal-content-demo">
                   <div class="modal-header">
                       <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                   </div>
                   <form action="section/destroy" method="post">
                       {{method_field('delete')}}
                       {{csrf_field()}}
                       <div class="modal-body">
                           <p>هل انت متاكد من عملية الحذف ؟</p><br>
                           <input type="hidden" name="id" id="id" value="">
                           <input class="form-control" name="section_name" id="section_name" type="text" readonly>
                       </div>
                       <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                           <button type="submit" class="btn btn-danger">تاكيد</button>
                       </div>
               </div>
               </form>
           </div>
       </div>

				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<script>
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var section_name = button.data('section_name')
        var description = button.data('description')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #section_name').val(section_name);
        modal.find('.modal-body #description').val(description);
    })
</script>
<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var section_name = button.data('section_name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #section_name').val(section_name);
    })
</script>
@endsection
