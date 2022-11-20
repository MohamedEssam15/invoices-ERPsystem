@extends('layouts.master2')
@section('css')
<!-- Sidemenu-respoansive-tabs css -->
<link href="{{URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
@endsection
@section('content')
		<div class="container-fluid">
			<div class="row no-gutter">
				<!-- The image half -->

				<!-- The content half -->
				<div class="col-md-6 col-lg-6 col-xl-5 bg-white">
					<div class="login d-flex align-items-center py-2">
						<!-- Demo content-->
						<div class="container p-0">
							<div class="row">
								<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
									<div class="card-sigin">
										<div class="mb-5 d-flex"> <a href="{{ url('/' . $page='home') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="sign-favicon ht-40" alt="logo"></a><h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">inv<span>oic</span>es</h1></div>
										<div class="card-sigin">
											<div class="main-signup-header">
												<h2>مرحبا بك!</h2>
												<h5 class="font-weight-semibold mb-4">قم بتسجيل الدخول من فضلك</h5>
                                                @if ($errors->any())
                                                @foreach ( $errors->all() as $error )
                                                <div class="alert alert-solid-danger mg-b-0" role="alert">
                                                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                                    <span aria-hidden="true">&times;</span></button>
                                                    <strong>Oh snap!</strong> {{$error}}
                                                </div>
                                                @endforeach
                                                @endif
												<form action="{{route("signin")}}" method="post">
                                                    @csrf
													<div class="form-group">
														<label>Email</label> <input name="email" @error('email') is-invalid @enderror class="form-control" placeholder="Enter your email" type="text">

                                                    </div>
													<div class="form-group">
														<label>Password</label> <input name="password" class="form-control" placeholder="Enter your password" type="password">
													</div><button class="btn btn-main-primary btn-block">Sign In</button>

												</form>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div><!-- End -->
					</div>
				</div><!-- End -->
                <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
					<div class="row wd-100p mx-auto text-center">
						<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
							<img src="{{URL::asset('assets/img/media/login.png')}}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
@section('js')
@endsection
