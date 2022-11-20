<!-- Sidebar-right-->
		<div class="sidebar sidebar-left sidebar-animate">
			<div class="panel panel-primary card mb-0 box-shadow">
				<div class="tab-menu-heading border-0 p-3">
					<div class="card-title mb-0">الاشعارات المقرؤه</div>
					<div class="card-options mr-auto">
						<a href="#" class="sidebar-remove"><i class="fe fe-x"></i></a>
					</div>
				</div>
				<div class="panel-body tabs-menu-body latest-tasks p-0 border-0">
					<div class="tabs-menu ">
						<!-- Tabs -->
						<ul class="nav panel-tabs">
							<li><a href="#side1" data-toggle="tab"><i class="ion ion-md-notifications tx-18  ml-2"></i> الاشعارات المقرؤه</a></li>
						</ul>
					</div>
					<div class="tab-content">
						<div class="tab-pane  " id="side1">
							<div class="list-group list-group-flush ">
                                @foreach(auth()->user()->readnotifications as $notification)
								<div class="list-group-item d-flex  align-items-center">
									<div class="ml-3">
										<span><div class="notifyimg bg-black">
                                            <i class="far fa-envelope"></i>
                                        </div></span>
									</div>
                                    <div>
										<a class="d-flex p-3 border-bottom"
                                                    href="{{ url('InvoicesDetails') }}/{{ $notification->data['id'] }}">

                                                    <div class="mr-3">
                                                        <h5 class="notification-label mb-1">{{ $notification->data['title'] }}
                                                            {{ $notification->data['user'] }}
                                                        </h5>
                                                        <div class="notification-subtext">{{ $notification->created_at->diffForhumans() }}</div>
                                                    </div>
                                                </a>
									</div>
								</div>

                                @endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<!--/Sidebar-right-->
