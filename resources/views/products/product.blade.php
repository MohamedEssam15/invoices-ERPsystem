@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    المنتجات</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-outline-danger mg-b-0" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span></button>
                    <strong>{{ $error }}</strong>
                </div>
            @endforeach
        @endif
        @if (session()->has('error'))
            <div class="alert alert-outline-warning" role="alert">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span></button>
                <strong>{{ session()->get('error') }}</strong>
            </div>
        @endif
        @if (session()->has('delete'))
            <div class="alert alert-outline-warning" role="alert">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span></button>
                <strong>{{ session()->get('delete') }}</strong>
            </div>
        @endif
        @if (session()->has('edit'))
            <div class="alert alert-outline-success" role="alert">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span></button>
                <strong>{{ session()->get('edit') }}</strong>
            </div>
        @endif
        @if (session()->has('Add'))
            <div class="alert alert-outline-success" role="alert">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span></button>
                <strong>{{ session()->get('Add') }}</strong>
            </div>
        @endif
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        @can('اضافة منتج')
                        <div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
                            <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-flip-vertical"
                                data-toggle="modal" href="#modaldemo8">اضافه منتج</a>
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
                                    <th>اسم القسم</th>
                                    <th>الوصف</th>
                                    <th>تاريخ الانشاء</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;

                                @endphp
                                @foreach ($products as $product)
                                    <tr>
                                        <th scope="row">{{ $i++ }}</th>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->section->section_name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            @can('تعديل منتج')
                                            <button class="btn btn-outline-success btn-sm"
                                                data-name="{{ $product->product_name }}" data-pro_id="{{ $product->id }}"
                                                data-section_name="{{ $product->section->section_name }}"
                                                data-description="{{ $product->description }}" data-toggle="modal"
                                                data-target="#edit_Product">تعديل</button>
                                                @endcan
                                                @can('حذف منتج')

                                            <button class="btn btn-outline-danger btn-sm "
                                                data-pro_id="{{ $product->id }}"
                                                data-product_name="{{ $product->product_name }}" data-toggle="modal"
                                                data-target="#modaldemo9">حذف</button>
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
                            <form method="post" action="{{ route('products.store') }}">
                                @csrf
                                <div class="modal-header">
                                    <h6 class="modal-title">اضافه منتج</h6><button aria-label="Close" class="close"
                                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
                                            <!--div-->
                                            <div class="card">


                                                <div class="card-body">
                                                    <div class="row row-sm">
                                                        <div class="col-lg">
                                                            <label>اسم المنتج</label>
                                                            <input class="form-control" placeholder="اسم المنتج"
                                                                name="product_name" type="text">
                                                        </div>
                                                    </div>
                                                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                                                    <select name="section_id" id="section_id" class="form-control" required>
                                                        <option value="" selected disabled> --حدد القسم--</option>
                                                        @foreach ($sections as $section)
                                                            <option value="{{ $section->id }}">
                                                                {{ $section->section_name }}</option>
                                                        @endforeach
                                                    </select>
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
                                        <button class="btn ripple btn-secondary" data-dismiss="modal"
                                            type="button">اغلق</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <!-- edit -->
  <div class="modal fade" id="edit_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">تعديل منتج</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form action='products/update' method="post">
              {{ method_field('patch') }}
              {{ csrf_field() }}
              <div class="modal-body">

                  <div class="form-group">
                      <label for="title">اسم المنتج :</label>

                      <input type="hidden" class="form-control" name="pro_id" id="pro_id" value="">

                      <input type="text" class="form-control" name="Product_name" id="Product_name">
                  </div>

                  <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                  <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>
                      @foreach ($sections as $section)
                          <option >{{ $section->section_name }}</option>
                      @endforeach
                  </select>

                  <div class="form-group">
                      <label for="des">ملاحظات :</label>
                      <textarea name="description" cols="20" rows="5" id='description'
                          class="form-control"></textarea>
                  </div>

              </div>
              <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">تعديل البيانات</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
              </div>
          </form>
      </div>
  </div>
</div>

<!-- delete -->
<div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">حذف المنتج</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form action="products/destroy" method="post">
              {{ method_field('delete') }}
              {{ csrf_field() }}
              <div class="modal-body">
                  <p>هل انت متاكد من عملية الحذف ؟</p><br>
                  <input type="hidden" name="pro_id" id="pro_id" value="">
                  <input class="form-control" name="product_name" id="product_name" type="text" readonly>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                  <button type="submit" class="btn btn-danger">تاكيد</button>
              </div>
          </form>
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
    <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

    <script>
        $('#edit_Product').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var Product_name = button.data('name')
            var section_name = button.data('section_name')
            var pro_id = button.data('pro_id')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #Product_name').val(Product_name);
            modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #pro_id').val(pro_id);
        })


        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var pro_id = button.data('pro_id')
            var product_name = button.data('product_name')
            var modal = $(this)

            modal.find('.modal-body #pro_id').val(pro_id);
            modal.find('.modal-body #product_name').val(product_name);
        })

    </script>

@endsection
