<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Genesis CRM+</title>

    {{--Template CSS--}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{--Main--}}
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    {{--Chosen--}}
    <link href="{{ asset('css/plugins/chosen/chosen.css') }}" rel="stylesheet">

    {{--Gritter--}}
    <link href="{{ asset('js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">

    {{--Data Tables--}}
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}" rel="stylesheet">

    {{--Form Wizard--}}
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">

    {{--SweetAlert CSS--}}
    <link rel="stylesheet" href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}">

    {{--SinchSDK--}}
    <script src="{{asset('js/sinch.min.js')}}"></script>
    {{--jQuery--}}
    <script src="{{ asset('js/jquery-2.1.1.js') }}"></script>

    {{--SweetAlert JS--}}
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    {{--DataPicker--}}
    <link rel="stylesheet" href="{{ asset('css/plugins/datapicker/datepicker3.css') }}">

    {{--ClockPicker--}}
    <link href="{{ asset('css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">

    {{--iON RangeSlider--}}
    <link href="{{ asset('css/plugins/ionRangeSlider/ion.rangeSlider.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/ionRangeSlider/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">

    {{--SummerNote--}}
    <link href="{{ asset('css/plugins/summernote/summernote.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/summernote/summernote-bs3.css') }}" rel="stylesheet">

    {{--Chosen--}}
    <link href="{{ asset('css/plugins/chosen/chosen.css') }}" rel="stylesheet">
</head>
<body>
<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="{{ asset('img/profile_small.jpg') }}" />
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth::user()->name }}</strong>
                             </span>
                                <span><small>{{ Auth::user()->email }}</small></span>
                                <span class="text-muted text-xs block">{{ $organization->role }}
                                    <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            @if($organization->role == 'admin')
                                <li>
                                    <a href="{{ url('/manage-team')}}">Manage Organization</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ url('/change-password')}}">Change Password</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element">
                        CRM+
                    </div>
                </li>
                <li>
                    <a href="" data-toggle="modal" data-target="#modal-lead-create"><i class="fa fa-plus"></i>
                        <span class="nav-label">New Lead</span></a>
                </li>
                <li {{ (Request::is('opportunities') ? 'class=active' : '') }}>
                    <a href="{{ url('/opportunities') }}"><i class="fa fa-th-large"></i>
                        <span class="nav-label">Opportunities</span></a>
                </li>
                <li {{ (Request::is('leads') ? 'class=active' : '') }}>
                    <a href="{{ url('/leads') }}"><i class="fa fa-list"></i>
                        <span class="nav-label">Leads</span></a>
                </li>
                <li {{ (Request::is('') ? 'class=active' : '') }}>
                    <a href="{{ url('') }}"><i class="fa fa-inbox"></i> <span class="nav-label">Inbox</span> </a>
                </li>

                <li {{ (Request::is('reports') ? 'class=active' : '') }}>
                    <a href=""><i class="fa fa-pie-chart"></i> <span class="nav-label">Reporting</span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li {{ (Request::is('reports') ? 'class=active' : '') }}><a href="{{ url('reports') }}">Activity</a></li>
                        <li><a href="{{ url('') }}">Status Changes</a></li>
                        <li><a href="{{ url('') }}">Explorer</a></li>
                        <li><a href="{{ url('') }}">Sent Email</a></li>
                    </ul>
                </li>

            </ul>

        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message">Genesis CRM+</span>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-envelope"></i> <span class="label label-warning">16</span>
                        </a>
                        <ul class="dropdown-menu dropdown-messages">
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="img/a7.jpg">
                                    </a>
                                    <div class="media-body">
                                        <small class="pull-right">46h ago</small>
                                        <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>.
                                        <br>
                                        <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="img/a4.jpg">
                                    </a>
                                    <div class="media-body ">
                                        <small class="pull-right text-navy">5h ago</small>
                                        <strong>Chris Johnatan Overtunk</strong> started following
                                        <strong>Monica Smith</strong>. <br>
                                        <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="dropdown-messages-box">
                                    <a href="profile.html" class="pull-left">
                                        <img alt="image" class="img-circle" src="img/profile.jpg">
                                    </a>
                                    <div class="media-body ">
                                        <small class="pull-right">23h ago</small>
                                        <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                        <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="mailbox.html">
                                        <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell"></i> <span class="label label-primary">8</span>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="mailbox.html">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="profile.html">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="grid_options.html">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="notifications.html">
                                        <strong>See All Alerts</strong>
                                        <i class="fa fa-angle-right"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>


                    <li>
                        <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>

                </ul>

            </nav>
        </div>
        @yield('content')

        {{--Modals--}}
        <div class="modal inmodal fade" id="modal-lead-create" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    {!! Form::open(array('route' => 'lead.store','method'=>'POST')) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                        <h4 class="modal-title">New lead</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                            {!! Form::label('title', 'Company/Organization Name *') !!}
                            {!! Form::text('title',null, array('class' => 'form-control input-sm', 'id' => 'title','required')) !!}
                            @if ($errors->has('title'))
                                <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
                            {!! Form::label('url', 'Website url') !!}
                            {!! Form::text('url', null, array('class' => 'form-control input-sm', 'id' => 'url')) !!}
                            @if ($errors->has('url'))
                                <span class="help-block">
                                <strong>{{ $errors->first('url') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::text('description',null, array('class' => 'form-control input-sm', 'id' => 'description')) !!}
                            @if ($errors->has('description'))
                                <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        {!! Form::submit('Save Lead',array('class'=>'btn btn-primary pull-right'))   !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

{{--Default Scripts--}}
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>

{{--Mainly scripts--}}
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

{{--ChosenJS--}}
<script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>

{{--Flot--}}
<script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
<script src="{{ asset('js/plugins/flot/jquery.flot.spline.js') }}"></script>
<script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>

{{--Peity--}}
<script src="{{ asset('js/plugins/peity/jquery.peity.min.js') }}"></script>
<script src="{{ asset('js/demo/peity-demo.js') }}"></script>

{{--DataTables--}}
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>

{{--Custom Plugins--}}
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

{{--jQuery UI--}}
<script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

{{--Gitter--}}
<script src="{{ asset('js/plugins/gritter/jquery.gritter.min.js') }}"></script>

{{--SparkLine--}}
<script src="{{ asset('js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

{{--SparkLine Demo--}}
<script src="{{ asset('js/demo/sparkline-demo.js') }}"></script>

{{--ChartJS--}}
<script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>

<!-- Toastr -->
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>

{{--Steps--}}
<script src="{{ asset('js/plugins/staps/jquery.steps.min.js') }}"></script>

{{--Jquery Validate--}}
<script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>

{{--DataPicker--}}
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>

{{--ClockPicker--}}
<script src="{{ asset('js/plugins/clockpicker/clockpicker.js') }}"></script>

{{--iON RangeSlider--}}
<script src="{{ asset('js/plugins/ionRangeSlider/ion.rangeSlider.min.js') }}"></script>

{{--SummerNote--}}
<script src="{{ asset('js/plugins/summernote/summernote.min.js') }}"></script>

{{--Chosen--}}
<script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>


{{--Page Level Scripts--}}
<script type="text/javascript">
	$('.dtb-opportunities').DataTable();

	// Feed Components
	$('.feed-edit').on('click', function () {
		$("#feed_id").val($(this).attr("data-feed-id"));
		$("#feed_value_update").val($(this).attr("data-feed-value"));
	});

	// Task Components
	$('#task_date').datepicker({
		minDate           : 0,
		todayBtn          : "linked",
		keyboardNavigation: false,
		forceParse        : false,
		calendarWeeks     : true,
		autoclose         : true
	});

	// Task Components
	$('#task_date_update').datepicker({
		minDate           : 0,
		todayBtn          : "linked",
		keyboardNavigation: false,
		forceParse        : false,
		calendarWeeks     : true,
		autoclose         : true,
	});

	$('.task-edit').on('click', function () {
		$("#task_id").val($(this).attr("data-task-id"));
		$("#task_message_update").val($(this).attr("data-task-message"));
		$("#task_date_update").val($(this).attr("data-task-date"));
		$("#task_time_update").val($(this).attr("data-task-time"));
	});
	$('.clockpicker').clockpicker();


	// Opportunity Components
	$('#opportunity_date_picker').find('.input-group.date').datepicker({
		minDate           : 0,
		todayBtn          : "linked",
		keyboardNavigation: false,
		forceParse        : false,
		calendarWeeks     : true,
		autoclose         : true
	});

	$('.opportunity-edit').on('click', function () {
		$("#opportunity_id").val($(this).attr("data-oppor-id"));
		$("#opportunity_status_update").val($(this).attr("data-oppor-status"));
		$("#opportunity_value_update").val($(this).attr("data-oppor-value"));
		$("#opportunity_value_period_update").val($(this).attr("data-oppor-value-period"));
		$("#opportunity_close_date_update").val($(this).attr("data-oppor-close-date"));
		$("#opportunity_confidence_update").val($(this).attr("data-oppor-confidence"));
		$("#opportunity_cid_update").val($(this).attr("data-oppor-cid"));
		$("#opportunity_uid_update").val($(this).attr("data-oppor-uid"));
		$("#opportunity_comment_update").val($(this).attr("data-oppor-comments"));
	});

	$('#opportunity_date_picker_update').find('.input-group.date').datepicker({
		minDate           : 0,
		todayBtn          : "linked",
		keyboardNavigation: false,
		forceParse        : false,
		calendarWeeks     : true,
		autoclose         : true,
	});

	// Contact Components
	$('.contact-edit').on('click', function () {
		$("#contact_id").val($(this).attr("data-contact-id"));
		$("#contact_name_update").val($(this).attr("data-contact-name"));
		$("#contact_title_update").val($(this).attr("data-contact-title"));
	});


	// Contact List Components
	$('.contact-list-add').on('click', function () {
		$("#parent_contact_id").val($(this).attr("data-contact-id"));
	});

//	var config = {
//		'.chosen-select'           : {},
//		'.chosen-select-deselect'  : {allow_single_deselect: true},
//		'.chosen-select-no-single' : {disable_search_threshold: 10},
//		'.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
//		'.chosen-select-width'     : {width: "95%"}
//	};
//	for (var selector in config) {
//		$(selector).chosen(config[selector]);
//	}

	$('#modal-create-email').on('shown.bs.modal', function () {
		$('.chosen-select', this).chosen('destroy').chosen();
	});

	// DataTables
	$('.db-leads').DataTable({
		dom    : '<"html5buttons"B>lTfgitp',
		buttons: [
			{extend: 'copy'},
			{extend: 'csv'},
			{extend: 'excel', title: 'ExampleFile'},
			{extend: 'pdf', title: 'ExampleFile'},

			{
				extend   : 'print',
				customize: function (win) {
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
				}
			}
		]

	});


</script>
<script type="text/javascript">
    $(document).ready(function(){
    	// Summer note
		$('.form-email').summernote();

	});
</script>

</body>
</html>
