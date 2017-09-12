@extends('layouts.app')

@section('content')
    <audio src="{{asset('ringing.mp3')}}" id="ringback" loop></audio>
    <audio src="" id="incoming" autoplay></audio>
    <div class="row border-bottom navy-bg dashboard-header m-b-lg">
        <div class="col-sm-6">
            <h2>{{ $lead->title }}
                <a class="text-white" href="" data-toggle="modal" data-target="#modal-udpate-lead"><i class="fa fa-cogs"></i></a>
            </h2>

            @if($lead->url != null)
                <a class="text-warning" href="{{ $lead->url }}">{{ $lead->url }}</a>
            @else
                <a href="" disabled="" class="text-warning">No url set</a>
            @endif
            <p>
                <small>
                    @if($lead->address != null)
                        {{ $lead->address }}
                    @else
                        No address set
                    @endif
                </small>
            </p>
            <h3>
                @if($lead->description != null)
                    {{ $lead->description }}
                @else
                    No description given
                @endif
            </h3>

        </div>


        {{--lead status option--}}
        <div class="col-sm-3 pull-right">
            {!! Form::open(array('id'=>'form_lead_status','route' => array('lead.update',0),'method'=>'PATCH')) !!}
            <select name="lead_status" required class="form-control white-bg" id="lead_status" title="lead_status">
                <option value="bad_fit">Bad Fit</option>
                <option value="potential">Potential</option>
                <option value="qualified">Qualified</option>
                <option value="customer">Customer</option>
                <option value="interested">Interested</option>
                <option value="canceled">Canceled</option>
                <option value="not interested">Not Interested</option>
            </select>
            <input type="hidden" name="lead_id" id="lead_id" value="{{ $hashids->encode($lead->id) }}">
            {!! Form::close() !!}
        </div>
        <script type="text/javascript">
			var lead_status = "#lead_status";
			$(lead_status).val('{{ $lead->status }}');
			$(lead_status).on('change', function () {
				$("#form_lead_status").submit();
			});

        </script>
        {{--end lead status option--}}

    </div>

    <div class="row">
        <div class="col-xs-5">
            <div class="task">
                <div class="row">
                    <div class="col-xs-12 m-b-xs">
                        <p>
                            <small>Tasks</small>
                        </p>
                        <a href="" class="btn btn-white btn-md" data-toggle="modal" data-target="#modal-create-task"><i class="fa fa-plus"></i> Task</a>
                    </div>
                </div>
                @if($lead_tasks->count() > 0)
                    @foreach($lead_tasks as $lead_task)
                        <div class="ibox">
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <h3>{{ $lead_task->message }}</h3>
                                    </div>
                                    <div class="pull-right m-r-xs">
                                        <button class="task-edit btn btn-white btn-xs" data-task-message="{{ $lead_task->message }}" data-task-date="{{ $lead_task->date }}" data-task-time="{{ $lead_task->time }}" data-task-id="{{ $hashids->encode($lead_task->id) }}" data-toggle="modal" data-target="#modal-update-task">
                                            <i class="fa fa-pencil"></i> Edit
                                        </button>
                                        <div class="pull-right">
                                            @if($lead_tasks->count() > 0)
                                                {!! Form::open(array('route' => array('lead-task.destroy',$hashids->encode($lead_task->id)),'method'=>'DELETE')) !!}
                                                {!! Form::submit('Delete',array('class'=>'btn btn-white btn-xs'))   !!}
                                                {!! Form::close() !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <small>Due on {{ $lead_task->date }} @ {{ $lead_task->time }}</small>
                                    </div>
                                    <div class="col-xs-6">
                                        <small>Posted by {{ $lead_task->name }}</small>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    No tasks available
                @endif
            </div>
            <hr />
            <div class="opportunities">
                <div class="row">
                    <div class="col-xs-12 m-b-xs">
                        <p>
                            <small>Opportunities</small>
                        </p>
                        <a href="" class="btn btn-white btn-md" data-toggle="modal" data-target="#modal-create-opportunity"><i class="fa fa-plus"></i> Opportunity</a>
                    </div>
                </div>
                @if($lead_opportunities->count() > 0)
                    @foreach($lead_opportunities as $lead_opportunity)
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>${{ $lead_opportunity->value }} {{ $lead_opportunity->value_period }}</h5>

                                <div class="pull-right">
                                    <button class="opportunity-edit btn btn-white btn-xs" data-oppor-id="{{ $hashids->encode( $lead_opportunity->id) }}" data-oppor-status="{{ $lead_opportunity->status}}" data-oppor-value="{{ $lead_opportunity->value }}" data-oppor-value-period="{{ $lead_opportunity->value_period}}" data-oppor-confidence="{{ $lead_opportunity->confidence }}" data-oppor-close-date="{{ $lead_opportunity->close_date}}" data-oppor-cid="{{ $lead_opportunity->contact_id}}" data-oppor-uid="{{ $lead_opportunity->user_id}}" data-oppor-comments="{{ $lead_opportunity->comments}}" data-toggle="modal" data-target="#modal-update-opportunity">
                                        <i class="fa fa-pencil"></i> Edit
                                    </button>
                                    <div class="pull-right">
                                        @if($lead_opportunities->count() > 0)
                                            {!! Form::open(array('route' => array('lead-opportunity.destroy',$hashids->encode($lead_opportunity->id)),'method'=>'DELETE')) !!}
                                            {!! Form::submit('Delete',array('class'=>'btn btn-white btn-xs'))   !!}
                                            {!! Form::close() !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-xs-6">
                                         <span class="label
                                             @if($lead_opportunity->status == "lost")
                                                 label-danger
                                             @else
                                                 label-primary
                                             @endif ">
                                    {{ $lead_opportunity->status }}
                                </span>
                                    </div>
                                    <div class="col-xs-6">
                                        <small>Completion with: {{ $lead_opportunity->confidence }}%</small>
                                        <div class="progress progress-mini">
                                            <div style="width: {{ $lead_opportunity->confidence }}%;" class="progress-bar"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <small>Created on: {{ $lead_opportunity->created_at }}</small>
                                    </div>
                                    <div class="col-xs-6 m-t-xs pull-right">
                                        <small>Close Date: {{ $lead_opportunity->close_date }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    No opportunities available
                @endif
            </div>
            <hr />
            <div class="contacts">
                <div class="row">
                    <div class="col-xs-12 m-b-xs">
                        <p>
                            <small>Contacts</small>
                        </p>
                        <a href="" class="btn btn-white btn-md" data-toggle="modal" data-target="#modal-create-contact"><i class="fa fa-plus"></i> Contact</a>
                    </div>
                </div>
                @if($lead_contacts->count() > 0)
                    @foreach($lead_contacts as $lead_contact)
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>{{ $lead_contact->contact_name }} |
                                    <small>{{ $lead_contact->contact_title }}</small>
                                </h5>
                                <div class="pull-right">
                                    <button class="contact-edit btn btn-white btn-xs" data-contact-id="{{ $hashids->encode( $lead_contact->id) }}" data-contact-name="{{ $lead_contact->contact_name}}" data-contact-title="{{ $lead_contact->contact_title}}" data-toggle="modal" data-target="#modal-update-contact">
                                        <i class="fa fa-pencil"></i> Edit
                                    </button>
                                    <button class="contact-list-add btn btn-white btn-xs" data-contact-id="{{ $hashids->encode( $lead_contact->id) }}" data-toggle="modal" data-target="#modal-create-contact-list">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                    <div class="pull-right">
                                        @if($lead_contacts->count() > 0)
                                            {!! Form::open(array('route' => array('lead-contact.destroy',$hashids->encode($lead_contact->id)),'method'=>'DELETE')) !!}
                                            {!! Form::submit('Delete',array('class'=>'btn btn-white btn-xs'))   !!}
                                            {!! Form::close() !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <table class="table no-margins">
                                            @foreach(DB::table( 'lead_contact_lists' )->where( 'contact_id', $lead_contact->id )->orderBy( 'updated_at', 'desc' )->get() as $lead_contact_list)
                                                <tr>
                                                    <td class="no-borders">{{ $lead_contact_list->contact_type }}</td>
                                                    <td class="no-borders">{{ $lead_contact_list->contact_value }}</td>
                                                    <td class="no-borders pull-right">
                                                        {!! Form::open(array('route' => array('lead-contact-list.destroy',$hashids->encode($lead_contact_list->id)),'method'=>'DELETE')) !!}
                                                        <button type="submit" name="delete-contact-list" class="btn btn-danger btn-xs">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                        {!! Form::close() !!}
                                                    </td>
                                                    <td class="no-borders pull-right">
                                                        @if($lead_contact_list->contact_type == "url")
                                                            <a href="http://{{ $lead_contact_list->contact_value }}" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-mail-forward"></i></a>
                                                        @elseif($lead_contact_list->contact_type == "mobile" or $lead_contact_list->contact_type == "phone")
                                                            <a href="#" id="call-phone" data-toggle="modal" data-target="#modal-call-lead" data-number="{{$lead_contact_list->contact_value}}" class="btn btn-primary btn-xs"><i class="fa fa-phone"></i></a>
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    No contacts available
                @endif
            </div>
            <hr>
        </div>
        <div class="col-xs-7">
            <div class="row">
                <div class="col-xs-12 m-b-lg">
                    <div class="btn-group">
                        <a href="" class="btn btn-white btn-md" data-toggle="modal" data-target="#modal-create-feed"><i class="fa fa-bookmark"></i> Note</a>
                        <a href="" class="btn btn-white btn-md" data-toggle="modal" data-target="#modal-create-email"><i class="fa fa-inbox"></i> Email</a>
                        <a href="" class="btn btn-white btn-md" data-toggle="modal" data-target="#modal-custom-call"><i class="fa fa-phone"></i> Call</a>
                    </div>
                </div>
            </div>
            <div id="vertical-timeline" class="vertical-container light-timeline no-margins">
                @if($lead_feeds->count() > 0)
                    @foreach($lead_feeds as $lead_feed)
                        <div class="vertical-timeline-block">
                            <div class="vertical-timeline-icon navy-bg">
                                {{--Identifies the icon for the type of feed--}}
                                @if($lead_feed->type == 'initial')
                                    <i class="fa fa-users"></i>
                                @elseif($lead_feed->type == 'note')
                                    <i class="fa fa-bookmark"></i>
                                @elseif($lead_feed->type == 'email')
                                    <i class="fa fa-inbox"></i>
                                @elseif($lead_feed->type == 'call')
                                    <i class="fa fa-phone"></i>
                                @elseif($lead_feed->type == 'status')
                                    <i class="fa fa-refresh"></i>
                                @endif
                            </div>

                            <div class="vertical-timeline-content">
                                @if(Auth::user()->id == $lead_feed->user_id)
                                    @if($lead_feed->type !== 'status' && $lead_feed->type !== 'initial' && $lead_feed->type !== 'email')
                                        <div class="pull-right social-action dropdown">
                                            <button data-toggle="dropdown" class="dropdown-toggle btn-white">
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu m-t-xs">
                                                <li>
                                                    <button class="feed-edit btn btn-white btn-block" data-feed-value="{{ $lead_feed->value }}" data-feed-id="{{ $hashids->encode($lead_feed->id) }}" data-toggle="modal" data-target="#modal-update-feed">Edit</button>
                                                </li>
                                                <li>
                                                    {!! Form::open(array('route' => array('lead-feed.destroy',$hashids->encode($lead_feed->id)),'method'=>'DELETE')) !!}
                                                    {!! Form::submit('Delete',array('class'=>'btn btn-danger btn-block'))   !!}
                                                    {!! Form::close() !!}
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                @endif
                                <div class="social-avatar">
                                    <a href="" class="pull-left">
                                        <img alt="image" class="img-circle" src="{{ asset('img/a1.jpg') }}">
                                    </a>
                                    <div class="media-body">
                                        <a href="#">
                                            {{ $lead_feed->name }}
                                        </a>

                                        <small class="text-muted">Last updated {{ $lead_feed->updated_at }}</small>
                                    </div>
                                </div>
                                <div class="social-body">
                                    @if($lead_feed->type == 'email')
                                        @foreach(getThreadEmails($lead_feed->id) as $email)
                                            <ul class="list-group">
                                                <li class="list-group-item"><small><strong>To: {{ $email->receiver }}</strong></small></li>
                                                <li class="list-group-item"><small><strong>From: {{ $email->sender }}</strong></small></li>
                                                <li class="list-group-item"><small><strong>Message</strong></small><br>{{ $email->message }}</li>
                                            </ul>
                                        @endforeach
                                    @else
                                        <p>{{ $lead_feed->value }}</p>
                                    @endif
                                    <small class="text-muted">Created last {{ $lead_feed->created_at }}</small>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @else
                    No feeds available
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 m-l-md">
                {{--{!! Form::open(array('url' => '','method'=>'PUT')) !!}--}}
                {{--<button class="btn btn-primary m-b-xs btn-xs" type="submit">--}}
                {{--<span class="fa fa-share-alt"></span> Merge lead--}}
                {{--</button>--}}
                {{--{!! Form::close() !!}--}}
                {!! Form::open(array('route' => array('lead.destroy',$hashids->encode($lead->id)),'method'=>'DELETE')) !!}
                <button class="btn btn-danger m-b-xs btn-xs" type="submit"><span class="fa fa-trash"></span> Delete lead
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <br>
    {{--Modals--}}
    {{--Updating Lead Details--}}
    <div class="modal inmodal fade" id="modal-udpate-lead" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('route' => array('lead-details.update',$hashids->encode($lead->id)),'method'=>'PATCH')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h6 class="modal-title">Update lead details</h6>
                </div>
                <div class="modal-body">
                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                        {!! Form::label('title', 'Company/Organization Name *') !!}
                        {!! Form::text('title',$lead->title, array('class' => 'form-control input-sm', 'id' => 'title','required')) !!}
                        @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('url') ? ' has-error' : '' }}">
                        {!! Form::label('url', 'Website url') !!}
                        {!! Form::text('url', $lead->url, array('class' => 'form-control input-sm', 'id' => 'url')) !!}
                        @if ($errors->has('url'))
                            <span class="help-block">
                                <strong>{{ $errors->first('url') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                        {!! Form::label('address', 'Address') !!}
                        {!! Form::text('address',$lead->address, array('class' => 'form-control input-sm', 'id' => 'address')) !!}
                        @if ($errors->has('address'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                        {!! Form::label('description', 'Description') !!}
                        {!! Form::textarea('description',$lead->description, array('class' => 'form-control input-sm', 'id' => 'description')) !!}
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    {!! Form::submit('Save',array('class'=>'btn btn-primary pull-right'))   !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {{--Creating Feed--}}
    <div class="modal inmodal fade" id="modal-create-feed" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('route' => array('lead-feed.store'),'method'=>'POST')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h6 class="modal-title">Post a new note</h6>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('lead_feed_id',$hashids->encode($lead->id), array('class' => 'form-control input-sm', 'id' => 'lead_feed_id')) !!}
                    {!! Form::hidden('feed_type','note', array('class' => 'form-control input-sm', 'id' => 'feed_type')) !!}
                    <div class="form-group {{ $errors->has('feed_value') ? ' has-error' : '' }}">
                        {!! Form::textarea('feed_value',null, array('class' => 'form-control input-sm', 'id' => 'feed_value','required','title'=>'feed value')) !!}
                        @if ($errors->has('feed_value'))
                            <span class="help-block">
                                <strong>{{ $errors->first('feed_value') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    {!! Form::submit('Save',array('class'=>'btn btn-primary pull-right'))   !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {{--Updating lead feeds--}}
    <div class="modal inmodal fade" id="modal-update-feed" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('route'=>array('lead-feed.update',0),'method'=>'PATCH','id'=>'feed_update_form')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h6 class="modal-title">Update feed post</h6>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('feed_id',null, array('class' => 'form-control input-sm', 'id' => 'feed_id')) !!}
                    {!! Form::hidden('feed_type','note', array('class' => 'form-control input-sm', 'id' => 'feed_type')) !!}
                    <div class="form-group {{ $errors->has('feed_value_update') ? ' has-error' : '' }}">
                        {!! Form::textarea('feed_value_update',null, array('class' => 'form-control input-sm', 'id' => 'feed_value_update','placeholder'=>'What\'s on your mind?','required')) !!}
                        @if ($errors->has('feed_value_update'))
                            <span class="help-block">
                                <strong>{{ $errors->first('feed_value_update') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    {!! Form::submit('Save',array('class'=>'btn btn-primary pull-right'))   !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {{--Creating Task--}}
    <div class="modal inmodal fade" id="modal-create-task" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('route' => array('lead-task.store'),'method'=>'POST')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h6 class="modal-title">Add new task</h6>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('lead_task_id',$hashids->encode($lead->id), array('class' => 'form-control input-sm', 'id' => 'lead_task_id')) !!}
                    <div class="form-group {{ $errors->has('task_message') ? ' has-error' : '' }}">
                        {!! Form::textarea('task_message',null, array('class' => 'form-control input-sm', 'id' => 'task_message','rows'=>'5','required')) !!}
                        @if ($errors->has('task_message'))
                            <span class="help-block">
                                <strong>{{ $errors->first('task_message') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group" id="task_date_picker">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}" name="task_date" id="task_date">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" id="task_time" name="task_time" class="form-control" value="09:30">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    {!! Form::submit('Save',array('class'=>'btn btn-primary pull-right'))   !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {{--Updating Task--}}
    <div class="modal inmodal fade" id="modal-update-task" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('route'=>array('lead-task.update',0),'method'=>'PATCH','id'=>'task_update_form')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h6 class="modal-title">Updating task details</h6>
                </div>
                <div class="modal-body">
                    {!! Form::hidden('task_id',null, array('class' => 'form-control input-sm', 'id' => 'task_id')) !!}
                    <div class="form-group {{ $errors->has('task_message_update') ? ' has-error' : '' }}">
                        {!! Form::textarea('task_message_update',null, array('class' => 'form-control input-sm', 'id' => 'task_message_update','rows'=>'5','required')) !!}
                        @if ($errors->has('task_message_update'))
                            <span class="help-block">
                                <strong>{{ $errors->first('task_message_update') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group" id="task_date_picker">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}" name="task_date_update" id="task_date_update">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" id="task_time" name="task_time_update" class="form-control" value="09:30">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-xs-6 pull-right">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            {!! Form::submit('Save',array('class'=>'btn btn-primary pull-right'))   !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{--Creating Opportunity--}}
    <div class="modal inmodal fade" id="modal-create-opportunity" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('route' => array('lead-opportunity.store'),'method'=>'POST')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h6 class="modal-title">Add new opportunity</h6>
                </div>

                <div class="modal-body">
                    {!! Form::hidden('lead_opportunity_id',$hashids->encode($lead->id), array('class' => 'form-control input-sm', 'id' => 'lead_opportunity_id')) !!}
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <small>Status</small>
                                <select name="opportunity_status" id="opportunity_status" class="form-control" title="opportunity_status">
                                    <option value="active">active</option>
                                    <option value="won">won</option>
                                    <option value="lost">lost</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <small>Value</small>
                                <input type="text" name="opportunity_value" required placeholder="$0.0" class="form-control" id="opportunity_value" title="opportunity_value">
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <small>Value Period</small>
                                <select name="opportunity_value_period" id="opportunity_value_period" class="form-control" title="opportunity_value_period">
                                    <option value="annual">annual</option>
                                    <option value="monthly">monthly</option>
                                    <option value="one-time">one-time</option>
                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <small>Confidence</small>
                                <input id="opportunity_confidence" type="number" required value="0" min="0" max="100" class="form-control" name="opportunity_confidence" title="opportunity_confidence">
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <small>Estimated Close Date</small>
                            <div class="form-group" id="opportunity_date_picker">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}" name="opportunity_close_date" id="opportunity_close_date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <small>Contact</small>
                                <select name="opportunity_cid" id="opportunity_cid" class="form-control" title="opportunity_cid">
                                    @foreach($lead_contacts as $lead_contact)
                                        <option value="{{ $lead_contact->id }}">{{ $lead_contact->contact_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <small>User</small>
                                <select name="opportunity_uid" id="opportunity_uid" class="form-control" title="opportunity_uid">
                                    @foreach($lead_users as $lead_user)
                                        <option value="{{ $lead_user->id }}">{{ $lead_user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="opportunity_comments">Comments</label>
                                <textarea name="opportunity_comments" id="" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    {!! Form::submit('Save',array('class'=>'btn btn-primary pull-right'))   !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {{--Updating Opportunity--}}
    <div class="modal inmodal fade" id="modal-update-opportunity" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('route'=>array('lead-opportunity.update',0),'method'=>'PATCH','id'=>'oppor_update_form')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h6 class="modal-title">Add new opportunity</h6>
                </div>

                <div class="modal-body">
                    {!! Form::hidden('opportunity_id',null, array('class' => 'form-control input-sm', 'id' => 'opportunity_id')) !!}
                    {!! Form::hidden('lead_opportunity_id',$hashids->encode($lead->id), array('class' => 'form-control input-sm', 'id' => 'lead_opportunity_id')) !!}
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <small>Status</small>
                                <select name="opportunity_status_update" id="opportunity_status" class="form-control" title="opportunity_status_update">
                                    <option value="active">active</option>
                                    <option value="won">won</option>
                                    <option value="lost">lost</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <small>Value</small>
                                <input type="text" name="opportunity_value_update" required placeholder="$0.0" class="form-control" id="opportunity_value_update" title="opportunity_value_update">
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <small>Value Period</small>
                                <select name="opportunity_value_period_update" id="opportunity_value_period_update" class="form-control" title="opportunity_value_period_update">
                                    <option value="annual">annual</option>
                                    <option value="monthly">monthly</option>
                                    <option value="one-time">one-time</option>
                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <small>Confidence</small>
                                <input id="opportunity_confidence_update" required value="0" type="number" min="0" max="100" class="form-control" name="opportunity_confidence_update" title="opportunity_confidence_update">
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <small>Estimated Close Date</small>
                            <div class="form-group" id="opportunity_date_picker_update">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}" name="opportunity_close_date_update" id="opportunity_close_date_update">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <small>Contact</small>
                                <select name="opportunity_cid_update" id="opportunity_cid_update" class="form-control" title="opportunity_cid_update">
                                    @foreach($lead_contacts as $lead_contact)
                                        <option value="{{ $lead_contact->id }}">{{ $lead_contact->contact_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <small>User</small>
                                <select name="opportunity_uid_update" id="opportunity_uid_update" class="form-control" title="opportunity_uid_update">
                                    @foreach($lead_users as $lead_user)
                                        <option value="{{ $lead_user->id }}">{{ $lead_user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <label for="opportunity_comment_update">Comments</label>
                                <textarea name="opportunity_comment_update" id="opportunity_comment_update" title="opportunity_comment_update" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-xs-6 pull-right">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            {!! Form::submit('Save',array('class'=>'btn btn-primary pull-right'))   !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{--Creating Contact--}}
    <div class="modal inmodal fade" id="modal-create-contact" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('route' => array('lead-contact.store'),'method'=>'POST')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h6 class="modal-title">Add new contact</h6>
                </div>

                <div class="modal-body">
                    {!! Form::hidden('lead_contact_id',$hashids->encode($lead->id), array('class' => 'form-control input-sm', 'id' => 'lead_contact_id')) !!}
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <small>Contact name</small>
                                <input type="text" name="contact_name" required placeholder="Contact name" class="form-control" id="contact_name" title="contact_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <small>Contact title</small>
                                <input type="text" name="contact_title" required placeholder="CEO/Owner" class="form-control" id="contact_title" title="contact_title">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    {!! Form::submit('Save',array('class'=>'btn btn-primary pull-right'))   !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    {{--Updating Contact--}}
    <div class="modal inmodal fade" id="modal-update-contact" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('route' => array('lead-contact.update',0),'method'=>'PATCH','id'=>'contact_update_form')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h6 class="modal-title">Updating contact</h6>
                </div>

                <div class="modal-body">
                    {!! Form::hidden('contact_id',null, array('class' => 'form-control input-sm', 'id' => 'contact_id')) !!}
                    {!! Form::hidden('lead_contact_id',$hashids->encode($lead->id), array('class' => 'form-control input-sm', 'id' => 'lead_contact_id')) !!}
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <small>Contact name</small>
                                <input type="text" name="contact_name_update" required placeholder="Contact name" class="form-control" id="contact_name_update" title="contact_name_update">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <small>Contact title</small>
                                <input type="text" name="contact_title_update" required placeholder="CEO/Owner" class="form-control" id="contact_title_update" title="contact_title_update">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-xs-6 pull-right">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            {!! Form::submit('Save',array('class'=>'btn btn-primary pull-right'))   !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{--Creating Contact list--}}
    <div class="modal inmodal fade" id="modal-create-contact-list" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('route' => array('lead-contact-list.store'),'method'=>'POST')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h6 class="modal-title">Add new contact list</h6>
                </div>

                <div class="modal-body">
                    {!! Form::hidden('parent_contact_id',null, array('class' => 'form-control input-sm', 'id' => 'parent_contact_id')) !!}
                    {!! Form::hidden('lead_contact_id',$hashids->encode($lead->id), array('class' => 'form-control input-sm', 'id' => 'lead_contact_id')) !!}
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <small>Contact value</small>

                                <div class="row" id="contact_type_phone" hidden>
                                  <select name="contact_list_country_code" id="contact_list_country_code" class="form-control">
                                    <option data-countryCode="GB" value="44" Selected>UK (+44)</option>
                                    <option data-countryCode="US" value="1">USA (+1)</option>
                                    <optgroup label="Other countries">
                                    <option data-countryCode="DZ" value="213">Algeria (+213)</option>
                                    <option data-countryCode="AD" value="376">Andorra (+376)</option>
                                    <option data-countryCode="AO" value="244">Angola (+244)</option>
                                    <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
                                    <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
                                    <option data-countryCode="AR" value="54">Argentina (+54)</option>
                                    <option data-countryCode="AM" value="374">Armenia (+374)</option>
                                    <option data-countryCode="AW" value="297">Aruba (+297)</option>
                                    <option data-countryCode="AU" value="61">Australia (+61)</option>
                                    <option data-countryCode="AT" value="43">Austria (+43)</option>
                                    <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
                                    <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
                                    <option data-countryCode="BH" value="973">Bahrain (+973)</option>
                                    <option data-countryCode="BD" value="880">Bangladesh (+880)</option>
                                    <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
                                    <option data-countryCode="BY" value="375">Belarus (+375)</option>
                                    <option data-countryCode="BE" value="32">Belgium (+32)</option>
                                    <option data-countryCode="BZ" value="501">Belize (+501)</option>
                                    <option data-countryCode="BJ" value="229">Benin (+229)</option>
                                    <option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
                                    <option data-countryCode="BT" value="975">Bhutan (+975)</option>
                                    <option data-countryCode="BO" value="591">Bolivia (+591)</option>
                                    <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
                                    <option data-countryCode="BW" value="267">Botswana (+267)</option>
                                    <option data-countryCode="BR" value="55">Brazil (+55)</option>
                                    <option data-countryCode="BN" value="673">Brunei (+673)</option>
                                    <option data-countryCode="BG" value="359">Bulgaria (+359)</option>
                                    <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
                                    <option data-countryCode="BI" value="257">Burundi (+257)</option>
                                    <option data-countryCode="KH" value="855">Cambodia (+855)</option>
                                    <option data-countryCode="CM" value="237">Cameroon (+237)</option>
                                    <option data-countryCode="CA" value="1">Canada (+1)</option>
                                    <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
                                    <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
                                    <option data-countryCode="CF" value="236">Central African Republic (+236)</option>
                                    <option data-countryCode="CL" value="56">Chile (+56)</option>
                                    <option data-countryCode="CN" value="86">China (+86)</option>
                                    <option data-countryCode="CO" value="57">Colombia (+57)</option>
                                    <option data-countryCode="KM" value="269">Comoros (+269)</option>
                                    <option data-countryCode="CG" value="242">Congo (+242)</option>
                                    <option data-countryCode="CK" value="682">Cook Islands (+682)</option>
                                    <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
                                    <option data-countryCode="HR" value="385">Croatia (+385)</option>
                                    <option data-countryCode="CU" value="53">Cuba (+53)</option>
                                    <option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
                                    <option data-countryCode="CY" value="357">Cyprus South (+357)</option>
                                    <option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
                                    <option data-countryCode="DK" value="45">Denmark (+45)</option>
                                    <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
                                    <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
                                    <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
                                    <option data-countryCode="EC" value="593">Ecuador (+593)</option>
                                    <option data-countryCode="EG" value="20">Egypt (+20)</option>
                                    <option data-countryCode="SV" value="503">El Salvador (+503)</option>
                                    <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
                                    <option data-countryCode="ER" value="291">Eritrea (+291)</option>
                                    <option data-countryCode="EE" value="372">Estonia (+372)</option>
                                    <option data-countryCode="ET" value="251">Ethiopia (+251)</option>
                                    <option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
                                    <option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
                                    <option data-countryCode="FJ" value="679">Fiji (+679)</option>
                                    <option data-countryCode="FI" value="358">Finland (+358)</option>
                                    <option data-countryCode="FR" value="33">France (+33)</option>
                                    <option data-countryCode="GF" value="594">French Guiana (+594)</option>
                                    <option data-countryCode="PF" value="689">French Polynesia (+689)</option>
                                    <option data-countryCode="GA" value="241">Gabon (+241)</option>
                                    <option data-countryCode="GM" value="220">Gambia (+220)</option>
                                    <option data-countryCode="GE" value="7880">Georgia (+7880)</option>
                                    <option data-countryCode="DE" value="49">Germany (+49)</option>
                                    <option data-countryCode="GH" value="233">Ghana (+233)</option>
                                    <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
                                    <option data-countryCode="GR" value="30">Greece (+30)</option>
                                    <option data-countryCode="GL" value="299">Greenland (+299)</option>
                                    <option data-countryCode="GD" value="1473">Grenada (+1473)</option>
                                    <option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
                                    <option data-countryCode="GU" value="671">Guam (+671)</option>
                                    <option data-countryCode="GT" value="502">Guatemala (+502)</option>
                                    <option data-countryCode="GN" value="224">Guinea (+224)</option>
                                    <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
                                    <option data-countryCode="GY" value="592">Guyana (+592)</option>
                                    <option data-countryCode="HT" value="509">Haiti (+509)</option>
                                    <option data-countryCode="HN" value="504">Honduras (+504)</option>
                                    <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
                                    <option data-countryCode="HU" value="36">Hungary (+36)</option>
                                    <option data-countryCode="IS" value="354">Iceland (+354)</option>
                                    <option data-countryCode="IN" value="91">India (+91)</option>
                                    <option data-countryCode="ID" value="62">Indonesia (+62)</option>
                                    <option data-countryCode="IR" value="98">Iran (+98)</option>
                                    <option data-countryCode="IQ" value="964">Iraq (+964)</option>
                                    <option data-countryCode="IE" value="353">Ireland (+353)</option>
                                    <option data-countryCode="IL" value="972">Israel (+972)</option>
                                    <option data-countryCode="IT" value="39">Italy (+39)</option>
                                    <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
                                    <option data-countryCode="JP" value="81">Japan (+81)</option>
                                    <option data-countryCode="JO" value="962">Jordan (+962)</option>
                                    <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
                                    <option data-countryCode="KE" value="254">Kenya (+254)</option>
                                    <option data-countryCode="KI" value="686">Kiribati (+686)</option>
                                    <option data-countryCode="KP" value="850">Korea North (+850)</option>
                                    <option data-countryCode="KR" value="82">Korea South (+82)</option>
                                    <option data-countryCode="KW" value="965">Kuwait (+965)</option>
                                    <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
                                    <option data-countryCode="LA" value="856">Laos (+856)</option>
                                    <option data-countryCode="LV" value="371">Latvia (+371)</option>
                                    <option data-countryCode="LB" value="961">Lebanon (+961)</option>
                                    <option data-countryCode="LS" value="266">Lesotho (+266)</option>
                                    <option data-countryCode="LR" value="231">Liberia (+231)</option>
                                    <option data-countryCode="LY" value="218">Libya (+218)</option>
                                    <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
                                    <option data-countryCode="LT" value="370">Lithuania (+370)</option>
                                    <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
                                    <option data-countryCode="MO" value="853">Macao (+853)</option>
                                    <option data-countryCode="MK" value="389">Macedonia (+389)</option>
                                    <option data-countryCode="MG" value="261">Madagascar (+261)</option>
                                    <option data-countryCode="MW" value="265">Malawi (+265)</option>
                                    <option data-countryCode="MY" value="60">Malaysia (+60)</option>
                                    <option data-countryCode="MV" value="960">Maldives (+960)</option>
                                    <option data-countryCode="ML" value="223">Mali (+223)</option>
                                    <option data-countryCode="MT" value="356">Malta (+356)</option>
                                    <option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
                                    <option data-countryCode="MQ" value="596">Martinique (+596)</option>
                                    <option data-countryCode="MR" value="222">Mauritania (+222)</option>
                                    <option data-countryCode="YT" value="269">Mayotte (+269)</option>
                                    <option data-countryCode="MX" value="52">Mexico (+52)</option>
                                    <option data-countryCode="FM" value="691">Micronesia (+691)</option>
                                    <option data-countryCode="MD" value="373">Moldova (+373)</option>
                                    <option data-countryCode="MC" value="377">Monaco (+377)</option>
                                    <option data-countryCode="MN" value="976">Mongolia (+976)</option>
                                    <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
                                    <option data-countryCode="MA" value="212">Morocco (+212)</option>
                                    <option data-countryCode="MZ" value="258">Mozambique (+258)</option>
                                    <option data-countryCode="MN" value="95">Myanmar (+95)</option>
                                    <option data-countryCode="NA" value="264">Namibia (+264)</option>
                                    <option data-countryCode="NR" value="674">Nauru (+674)</option>
                                    <option data-countryCode="NP" value="977">Nepal (+977)</option>
                                    <option data-countryCode="NL" value="31">Netherlands (+31)</option>
                                    <option data-countryCode="NC" value="687">New Caledonia (+687)</option>
                                    <option data-countryCode="NZ" value="64">New Zealand (+64)</option>
                                    <option data-countryCode="NI" value="505">Nicaragua (+505)</option>
                                    <option data-countryCode="NE" value="227">Niger (+227)</option>
                                    <option data-countryCode="NG" value="234">Nigeria (+234)</option>
                                    <option data-countryCode="NU" value="683">Niue (+683)</option>
                                    <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
                                    <option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
                                    <option data-countryCode="NO" value="47">Norway (+47)</option>
                                    <option data-countryCode="OM" value="968">Oman (+968)</option>
                                    <option data-countryCode="PW" value="680">Palau (+680)</option>
                                    <option data-countryCode="PA" value="507">Panama (+507)</option>
                                    <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
                                    <option data-countryCode="PY" value="595">Paraguay (+595)</option>
                                    <option data-countryCode="PE" value="51">Peru (+51)</option>
                                    <option data-countryCode="PH" value="63">Philippines (+63)</option>
                                    <option data-countryCode="PL" value="48">Poland (+48)</option>
                                    <option data-countryCode="PT" value="351">Portugal (+351)</option>
                                    <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
                                    <option data-countryCode="QA" value="974">Qatar (+974)</option>
                                    <option data-countryCode="RE" value="262">Reunion (+262)</option>
                                    <option data-countryCode="RO" value="40">Romania (+40)</option>
                                    <option data-countryCode="RU" value="7">Russia (+7)</option>
                                    <option data-countryCode="RW" value="250">Rwanda (+250)</option>
                                    <option data-countryCode="SM" value="378">San Marino (+378)</option>
                                    <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
                                    <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
                                    <option data-countryCode="SN" value="221">Senegal (+221)</option>
                                    <option data-countryCode="CS" value="381">Serbia (+381)</option>
                                    <option data-countryCode="SC" value="248">Seychelles (+248)</option>
                                    <option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
                                    <option data-countryCode="SG" value="65">Singapore (+65)</option>
                                    <option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
                                    <option data-countryCode="SI" value="386">Slovenia (+386)</option>
                                    <option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
                                    <option data-countryCode="SO" value="252">Somalia (+252)</option>
                                    <option data-countryCode="ZA" value="27">South Africa (+27)</option>
                                    <option data-countryCode="ES" value="34">Spain (+34)</option>
                                    <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
                                    <option data-countryCode="SH" value="290">St. Helena (+290)</option>
                                    <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
                                    <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
                                    <option data-countryCode="SD" value="249">Sudan (+249)</option>
                                    <option data-countryCode="SR" value="597">Suriname (+597)</option>
                                    <option data-countryCode="SZ" value="268">Swaziland (+268)</option>
                                    <option data-countryCode="SE" value="46">Sweden (+46)</option>
                                    <option data-countryCode="CH" value="41">Switzerland (+41)</option>
                                    <option data-countryCode="SI" value="963">Syria (+963)</option>
                                    <option data-countryCode="TW" value="886">Taiwan (+886)</option>
                                    <option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
                                    <option data-countryCode="TH" value="66">Thailand (+66)</option>
                                    <option data-countryCode="TG" value="228">Togo (+228)</option>
                                    <option data-countryCode="TO" value="676">Tonga (+676)</option>
                                    <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
                                    <option data-countryCode="TN" value="216">Tunisia (+216)</option>
                                    <option data-countryCode="TR" value="90">Turkey (+90)</option>
                                    <option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
                                    <option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
                                    <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
                                    <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
                                    <option data-countryCode="UG" value="256">Uganda (+256)</option>
                                    <!-- <option data-countryCode="GB" value="44">UK (+44)</option> -->
                                    <option data-countryCode="UA" value="380">Ukraine (+380)</option>
                                    <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
                                    <option data-countryCode="UY" value="598">Uruguay (+598)</option>
                                    <!-- <option data-countryCode="US" value="1">USA (+1)</option> -->
                                    <option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
                                    <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
                                    <option data-countryCode="VA" value="379">Vatican City (+379)</option>
                                    <option data-countryCode="VE" value="58">Venezuela (+58)</option>
                                    <option data-countryCode="VN" value="84">Vietnam (+84)</option>
                                    <option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
                                    <option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
                                    <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
                                    <option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
                                    <option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
                                    <option data-countryCode="ZM" value="260">Zambia (+260)</option>
                                    <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
                                    </optgroup>
                                  </select>
                                  <input type="text" class="form-control" name="contact_list_number" id="contact_list_number" placeholder="Contact number">
                                </div>
                                <input type="text" name="contact_list_value" required class="form-control" id="contact_list_value" title="contact_list_value">
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <small>Contact list type</small>
                                <select name="contact_list_type" required class="form-control" id="contact_list_type" title="contact_list_type">
                                    <option value="url">URL</option>
                                    <option value="phone">Phone</option>
                                    <option value="mobile">Mobile</option>
                                    <option value="office">Office</option>
                                    <option value="email">Email</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    {!! Form::submit('Save',array('class'=>'btn btn-primary pull-right'))   !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    {{--Creating Email--}}
    <div class="modal inmodal fade modal-big" id="modal-create-email" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('route' => array('lead-email.store'),'method'=>'POST')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h6 class="modal-title">Send Email</h6>
                </div>

                <div class="modal-body" style="background:#fff">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                {!! Form::hidden('lead_feed_id',$hashids->encode($lead->id), array('class' => 'form-control input-sm', 'id' => 'lead_feed_id')) !!}
                                <small>{!! Form::label('email_receiver[]','Receiver') !!}</small>
                                <div class="input-group">
                                    <select data-placeholder="Choose email from contacts..." name="email_receiver[]" title="email_receiver[]" class="chosen-select" multiple style="width:400px;" tabindex="4">
                                        @foreach($lead_contacts as $lead_contact)
                                            <option value="{{ getContactEmail($lead_contact->id)}}">{{ getContactEmail($lead_contact->id)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <small>{!! Form::label('email_message','Message') !!}</small>
                                {!! Form::textarea('email_message',null, array('class' => 'form-control input-sm', 'id' => 'email_message','rows'=>'5','required')) !!}
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    {!! Form::submit('Send',array('class'=>'btn btn-primary pull-right'))   !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="modal-call-lead" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-body">
                <p id="call-status">Calling...
                </p>
                </p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-white" data-dismiss="modal" id="call-hangup">Hang up</button>
              </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="modal-custom-call" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-body">
                <div class="form-group">
                  <small>Contact value</small>
                  <select id="custom_country_code" class="form-control">
                    <option data-countryCode="GB" value="44" Selected>UK (+44)</option>
                    <option data-countryCode="US" value="1">USA (+1)</option>
                    <optgroup label="Other countries">
                    <option data-countryCode="DZ" value="213">Algeria (+213)</option>
                    <option data-countryCode="AD" value="376">Andorra (+376)</option>
                    <option data-countryCode="AO" value="244">Angola (+244)</option>
                    <option data-countryCode="AI" value="1264">Anguilla (+1264)</option>
                    <option data-countryCode="AG" value="1268">Antigua &amp; Barbuda (+1268)</option>
                    <option data-countryCode="AR" value="54">Argentina (+54)</option>
                    <option data-countryCode="AM" value="374">Armenia (+374)</option>
                    <option data-countryCode="AW" value="297">Aruba (+297)</option>
                    <option data-countryCode="AU" value="61">Australia (+61)</option>
                    <option data-countryCode="AT" value="43">Austria (+43)</option>
                    <option data-countryCode="AZ" value="994">Azerbaijan (+994)</option>
                    <option data-countryCode="BS" value="1242">Bahamas (+1242)</option>
                    <option data-countryCode="BH" value="973">Bahrain (+973)</option>
                    <option data-countryCode="BD" value="880">Bangladesh (+880)</option>
                    <option data-countryCode="BB" value="1246">Barbados (+1246)</option>
                    <option data-countryCode="BY" value="375">Belarus (+375)</option>
                    <option data-countryCode="BE" value="32">Belgium (+32)</option>
                    <option data-countryCode="BZ" value="501">Belize (+501)</option>
                    <option data-countryCode="BJ" value="229">Benin (+229)</option>
                    <option data-countryCode="BM" value="1441">Bermuda (+1441)</option>
                    <option data-countryCode="BT" value="975">Bhutan (+975)</option>
                    <option data-countryCode="BO" value="591">Bolivia (+591)</option>
                    <option data-countryCode="BA" value="387">Bosnia Herzegovina (+387)</option>
                    <option data-countryCode="BW" value="267">Botswana (+267)</option>
                    <option data-countryCode="BR" value="55">Brazil (+55)</option>
                    <option data-countryCode="BN" value="673">Brunei (+673)</option>
                    <option data-countryCode="BG" value="359">Bulgaria (+359)</option>
                    <option data-countryCode="BF" value="226">Burkina Faso (+226)</option>
                    <option data-countryCode="BI" value="257">Burundi (+257)</option>
                    <option data-countryCode="KH" value="855">Cambodia (+855)</option>
                    <option data-countryCode="CM" value="237">Cameroon (+237)</option>
                    <option data-countryCode="CA" value="1">Canada (+1)</option>
                    <option data-countryCode="CV" value="238">Cape Verde Islands (+238)</option>
                    <option data-countryCode="KY" value="1345">Cayman Islands (+1345)</option>
                    <option data-countryCode="CF" value="236">Central African Republic (+236)</option>
                    <option data-countryCode="CL" value="56">Chile (+56)</option>
                    <option data-countryCode="CN" value="86">China (+86)</option>
                    <option data-countryCode="CO" value="57">Colombia (+57)</option>
                    <option data-countryCode="KM" value="269">Comoros (+269)</option>
                    <option data-countryCode="CG" value="242">Congo (+242)</option>
                    <option data-countryCode="CK" value="682">Cook Islands (+682)</option>
                    <option data-countryCode="CR" value="506">Costa Rica (+506)</option>
                    <option data-countryCode="HR" value="385">Croatia (+385)</option>
                    <option data-countryCode="CU" value="53">Cuba (+53)</option>
                    <option data-countryCode="CY" value="90392">Cyprus North (+90392)</option>
                    <option data-countryCode="CY" value="357">Cyprus South (+357)</option>
                    <option data-countryCode="CZ" value="42">Czech Republic (+42)</option>
                    <option data-countryCode="DK" value="45">Denmark (+45)</option>
                    <option data-countryCode="DJ" value="253">Djibouti (+253)</option>
                    <option data-countryCode="DM" value="1809">Dominica (+1809)</option>
                    <option data-countryCode="DO" value="1809">Dominican Republic (+1809)</option>
                    <option data-countryCode="EC" value="593">Ecuador (+593)</option>
                    <option data-countryCode="EG" value="20">Egypt (+20)</option>
                    <option data-countryCode="SV" value="503">El Salvador (+503)</option>
                    <option data-countryCode="GQ" value="240">Equatorial Guinea (+240)</option>
                    <option data-countryCode="ER" value="291">Eritrea (+291)</option>
                    <option data-countryCode="EE" value="372">Estonia (+372)</option>
                    <option data-countryCode="ET" value="251">Ethiopia (+251)</option>
                    <option data-countryCode="FK" value="500">Falkland Islands (+500)</option>
                    <option data-countryCode="FO" value="298">Faroe Islands (+298)</option>
                    <option data-countryCode="FJ" value="679">Fiji (+679)</option>
                    <option data-countryCode="FI" value="358">Finland (+358)</option>
                    <option data-countryCode="FR" value="33">France (+33)</option>
                    <option data-countryCode="GF" value="594">French Guiana (+594)</option>
                    <option data-countryCode="PF" value="689">French Polynesia (+689)</option>
                    <option data-countryCode="GA" value="241">Gabon (+241)</option>
                    <option data-countryCode="GM" value="220">Gambia (+220)</option>
                    <option data-countryCode="GE" value="7880">Georgia (+7880)</option>
                    <option data-countryCode="DE" value="49">Germany (+49)</option>
                    <option data-countryCode="GH" value="233">Ghana (+233)</option>
                    <option data-countryCode="GI" value="350">Gibraltar (+350)</option>
                    <option data-countryCode="GR" value="30">Greece (+30)</option>
                    <option data-countryCode="GL" value="299">Greenland (+299)</option>
                    <option data-countryCode="GD" value="1473">Grenada (+1473)</option>
                    <option data-countryCode="GP" value="590">Guadeloupe (+590)</option>
                    <option data-countryCode="GU" value="671">Guam (+671)</option>
                    <option data-countryCode="GT" value="502">Guatemala (+502)</option>
                    <option data-countryCode="GN" value="224">Guinea (+224)</option>
                    <option data-countryCode="GW" value="245">Guinea - Bissau (+245)</option>
                    <option data-countryCode="GY" value="592">Guyana (+592)</option>
                    <option data-countryCode="HT" value="509">Haiti (+509)</option>
                    <option data-countryCode="HN" value="504">Honduras (+504)</option>
                    <option data-countryCode="HK" value="852">Hong Kong (+852)</option>
                    <option data-countryCode="HU" value="36">Hungary (+36)</option>
                    <option data-countryCode="IS" value="354">Iceland (+354)</option>
                    <option data-countryCode="IN" value="91">India (+91)</option>
                    <option data-countryCode="ID" value="62">Indonesia (+62)</option>
                    <option data-countryCode="IR" value="98">Iran (+98)</option>
                    <option data-countryCode="IQ" value="964">Iraq (+964)</option>
                    <option data-countryCode="IE" value="353">Ireland (+353)</option>
                    <option data-countryCode="IL" value="972">Israel (+972)</option>
                    <option data-countryCode="IT" value="39">Italy (+39)</option>
                    <option data-countryCode="JM" value="1876">Jamaica (+1876)</option>
                    <option data-countryCode="JP" value="81">Japan (+81)</option>
                    <option data-countryCode="JO" value="962">Jordan (+962)</option>
                    <option data-countryCode="KZ" value="7">Kazakhstan (+7)</option>
                    <option data-countryCode="KE" value="254">Kenya (+254)</option>
                    <option data-countryCode="KI" value="686">Kiribati (+686)</option>
                    <option data-countryCode="KP" value="850">Korea North (+850)</option>
                    <option data-countryCode="KR" value="82">Korea South (+82)</option>
                    <option data-countryCode="KW" value="965">Kuwait (+965)</option>
                    <option data-countryCode="KG" value="996">Kyrgyzstan (+996)</option>
                    <option data-countryCode="LA" value="856">Laos (+856)</option>
                    <option data-countryCode="LV" value="371">Latvia (+371)</option>
                    <option data-countryCode="LB" value="961">Lebanon (+961)</option>
                    <option data-countryCode="LS" value="266">Lesotho (+266)</option>
                    <option data-countryCode="LR" value="231">Liberia (+231)</option>
                    <option data-countryCode="LY" value="218">Libya (+218)</option>
                    <option data-countryCode="LI" value="417">Liechtenstein (+417)</option>
                    <option data-countryCode="LT" value="370">Lithuania (+370)</option>
                    <option data-countryCode="LU" value="352">Luxembourg (+352)</option>
                    <option data-countryCode="MO" value="853">Macao (+853)</option>
                    <option data-countryCode="MK" value="389">Macedonia (+389)</option>
                    <option data-countryCode="MG" value="261">Madagascar (+261)</option>
                    <option data-countryCode="MW" value="265">Malawi (+265)</option>
                    <option data-countryCode="MY" value="60">Malaysia (+60)</option>
                    <option data-countryCode="MV" value="960">Maldives (+960)</option>
                    <option data-countryCode="ML" value="223">Mali (+223)</option>
                    <option data-countryCode="MT" value="356">Malta (+356)</option>
                    <option data-countryCode="MH" value="692">Marshall Islands (+692)</option>
                    <option data-countryCode="MQ" value="596">Martinique (+596)</option>
                    <option data-countryCode="MR" value="222">Mauritania (+222)</option>
                    <option data-countryCode="YT" value="269">Mayotte (+269)</option>
                    <option data-countryCode="MX" value="52">Mexico (+52)</option>
                    <option data-countryCode="FM" value="691">Micronesia (+691)</option>
                    <option data-countryCode="MD" value="373">Moldova (+373)</option>
                    <option data-countryCode="MC" value="377">Monaco (+377)</option>
                    <option data-countryCode="MN" value="976">Mongolia (+976)</option>
                    <option data-countryCode="MS" value="1664">Montserrat (+1664)</option>
                    <option data-countryCode="MA" value="212">Morocco (+212)</option>
                    <option data-countryCode="MZ" value="258">Mozambique (+258)</option>
                    <option data-countryCode="MN" value="95">Myanmar (+95)</option>
                    <option data-countryCode="NA" value="264">Namibia (+264)</option>
                    <option data-countryCode="NR" value="674">Nauru (+674)</option>
                    <option data-countryCode="NP" value="977">Nepal (+977)</option>
                    <option data-countryCode="NL" value="31">Netherlands (+31)</option>
                    <option data-countryCode="NC" value="687">New Caledonia (+687)</option>
                    <option data-countryCode="NZ" value="64">New Zealand (+64)</option>
                    <option data-countryCode="NI" value="505">Nicaragua (+505)</option>
                    <option data-countryCode="NE" value="227">Niger (+227)</option>
                    <option data-countryCode="NG" value="234">Nigeria (+234)</option>
                    <option data-countryCode="NU" value="683">Niue (+683)</option>
                    <option data-countryCode="NF" value="672">Norfolk Islands (+672)</option>
                    <option data-countryCode="NP" value="670">Northern Marianas (+670)</option>
                    <option data-countryCode="NO" value="47">Norway (+47)</option>
                    <option data-countryCode="OM" value="968">Oman (+968)</option>
                    <option data-countryCode="PW" value="680">Palau (+680)</option>
                    <option data-countryCode="PA" value="507">Panama (+507)</option>
                    <option data-countryCode="PG" value="675">Papua New Guinea (+675)</option>
                    <option data-countryCode="PY" value="595">Paraguay (+595)</option>
                    <option data-countryCode="PE" value="51">Peru (+51)</option>
                    <option data-countryCode="PH" value="63">Philippines (+63)</option>
                    <option data-countryCode="PL" value="48">Poland (+48)</option>
                    <option data-countryCode="PT" value="351">Portugal (+351)</option>
                    <option data-countryCode="PR" value="1787">Puerto Rico (+1787)</option>
                    <option data-countryCode="QA" value="974">Qatar (+974)</option>
                    <option data-countryCode="RE" value="262">Reunion (+262)</option>
                    <option data-countryCode="RO" value="40">Romania (+40)</option>
                    <option data-countryCode="RU" value="7">Russia (+7)</option>
                    <option data-countryCode="RW" value="250">Rwanda (+250)</option>
                    <option data-countryCode="SM" value="378">San Marino (+378)</option>
                    <option data-countryCode="ST" value="239">Sao Tome &amp; Principe (+239)</option>
                    <option data-countryCode="SA" value="966">Saudi Arabia (+966)</option>
                    <option data-countryCode="SN" value="221">Senegal (+221)</option>
                    <option data-countryCode="CS" value="381">Serbia (+381)</option>
                    <option data-countryCode="SC" value="248">Seychelles (+248)</option>
                    <option data-countryCode="SL" value="232">Sierra Leone (+232)</option>
                    <option data-countryCode="SG" value="65">Singapore (+65)</option>
                    <option data-countryCode="SK" value="421">Slovak Republic (+421)</option>
                    <option data-countryCode="SI" value="386">Slovenia (+386)</option>
                    <option data-countryCode="SB" value="677">Solomon Islands (+677)</option>
                    <option data-countryCode="SO" value="252">Somalia (+252)</option>
                    <option data-countryCode="ZA" value="27">South Africa (+27)</option>
                    <option data-countryCode="ES" value="34">Spain (+34)</option>
                    <option data-countryCode="LK" value="94">Sri Lanka (+94)</option>
                    <option data-countryCode="SH" value="290">St. Helena (+290)</option>
                    <option data-countryCode="KN" value="1869">St. Kitts (+1869)</option>
                    <option data-countryCode="SC" value="1758">St. Lucia (+1758)</option>
                    <option data-countryCode="SD" value="249">Sudan (+249)</option>
                    <option data-countryCode="SR" value="597">Suriname (+597)</option>
                    <option data-countryCode="SZ" value="268">Swaziland (+268)</option>
                    <option data-countryCode="SE" value="46">Sweden (+46)</option>
                    <option data-countryCode="CH" value="41">Switzerland (+41)</option>
                    <option data-countryCode="SI" value="963">Syria (+963)</option>
                    <option data-countryCode="TW" value="886">Taiwan (+886)</option>
                    <option data-countryCode="TJ" value="7">Tajikstan (+7)</option>
                    <option data-countryCode="TH" value="66">Thailand (+66)</option>
                    <option data-countryCode="TG" value="228">Togo (+228)</option>
                    <option data-countryCode="TO" value="676">Tonga (+676)</option>
                    <option data-countryCode="TT" value="1868">Trinidad &amp; Tobago (+1868)</option>
                    <option data-countryCode="TN" value="216">Tunisia (+216)</option>
                    <option data-countryCode="TR" value="90">Turkey (+90)</option>
                    <option data-countryCode="TM" value="7">Turkmenistan (+7)</option>
                    <option data-countryCode="TM" value="993">Turkmenistan (+993)</option>
                    <option data-countryCode="TC" value="1649">Turks &amp; Caicos Islands (+1649)</option>
                    <option data-countryCode="TV" value="688">Tuvalu (+688)</option>
                    <option data-countryCode="UG" value="256">Uganda (+256)</option>
                    <!-- <option data-countryCode="GB" value="44">UK (+44)</option> -->
                    <option data-countryCode="UA" value="380">Ukraine (+380)</option>
                    <option data-countryCode="AE" value="971">United Arab Emirates (+971)</option>
                    <option data-countryCode="UY" value="598">Uruguay (+598)</option>
                    <!-- <option data-countryCode="US" value="1">USA (+1)</option> -->
                    <option data-countryCode="UZ" value="7">Uzbekistan (+7)</option>
                    <option data-countryCode="VU" value="678">Vanuatu (+678)</option>
                    <option data-countryCode="VA" value="379">Vatican City (+379)</option>
                    <option data-countryCode="VE" value="58">Venezuela (+58)</option>
                    <option data-countryCode="VN" value="84">Vietnam (+84)</option>
                    <option data-countryCode="VG" value="84">Virgin Islands - British (+1284)</option>
                    <option data-countryCode="VI" value="84">Virgin Islands - US (+1340)</option>
                    <option data-countryCode="WF" value="681">Wallis &amp; Futuna (+681)</option>
                    <option data-countryCode="YE" value="969">Yemen (North)(+969)</option>
                    <option data-countryCode="YE" value="967">Yemen (South)(+967)</option>
                    <option data-countryCode="ZM" value="260">Zambia (+260)</option>
                    <option data-countryCode="ZW" value="263">Zimbabwe (+263)</option>
                    </optgroup>
                  </select>
                  <input type="text" class="form-control" id="custom_number" placeholder="Contact number">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal" data-toggle="modal" data-target="#modal-call-lead" id="custom-call-phone">Call</button>
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
              </div>
            </div>
        </div>
    </div>



@endsection
