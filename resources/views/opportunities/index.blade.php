@extends('layouts.app')

@section('content')
    <div class="row  border-bottom white-bg dashboard-header m-b-lg">
        <div class="col-sm-6">
            <h2>Opportunities: {{ $opportunities->count() }}</h2>

            <h3>Summary</h3>
            <ul class="list-group clear-list m-t">
                <li class="list-group-item fist-item">
                    <span class="pull-right">
                        &nbsp;
                    </span>
                    <span class="label label-success">Total Value:</span>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        ${{ $total_one_time }}
                    </span>
                    <span class="label label-primary-darker">Total Value One Time</span>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        ${{ $total_monthly }}
                    </span>
                    <span class="label label-success">Total Value Monthly</span>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        ${{ $total_annual}}
                    </span>
                    <span class="label label-primary-darker">Total Value Annually</span>
                </li>
                <li class="list-group-item pull-right">
                    <h2>${{ $total_annualized }} annualized</h2>
                </li>
            </ul>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-xs-4">
                    <div class="form-group">
                        <label class="font-normal">Lead Name</label>
                        <div class="input-group">
                            <label>
                                <select data-placeholder="Choose lead..." class="chosen-select" style="width:150px;" tabindex="2">
                                    <option value="">Select</option>
                                    @foreach($leads as $lead)
                                        <option value="{{ $lead->id }}">{{ $lead->title }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="form-group">
                        <label class="font-normal">Lead Users</label>
                        <div class="input-group">
                            <label>
                                <select data-placeholder="Choose user..." class="chosen-select" style="width:150px;" tabindex="2">
                                    <option value="">Select</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="form-group">
                        <label class="font-normal">Lead Status</label>
                        <div class="input-group">
                            <label>
                                <select data-placeholder="Choose status..." class="chosen-select" style="width:100px;" tabindex="2">
                                    <option value="">Select</option>
                                    <option value="active">Active</option>
                                    <option value="won">Won</option>
                                    <option value="lost">Lost</option>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <div class="input-group">
                            <br/>
                            <label>
                               <button class="btn btn-primary btn-sm">GO</button>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <ul class="list-group clear-list m-t">
                <li class="list-group-item fist-item">
                    <span class="pull-right">
                        &nbsp;
                    </span>
                    <span class="label label-success">Expected Value:</span>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        $0
                    </span>
                    <span class="label label-primary-darker">Total Value Annually</span>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        $0
                    </span>
                    <span class="label label-success">Total Value Monthly</span>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        $0
                    </span>
                    <span class="label label-primary-darker">Total Value One time</span>
                </li>
                <li class="list-group-item pull-right">
                    <h2>$0 annualized</h2>
                </li>
            </ul>
        </div>
    </div>

    {{--Start Looping of Leads--}}
    @foreach($leads as $lead)
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-xs-12 border-bottom navy-bg dashboard-header">
                        <div class="col-sm-6">
                            <h2>
                                <a class="text-white" href="{{ route('lead.edit',$hashids->encode($lead->id)) }}">{{ $lead->title }}
                                    <i class="fa fa-edit"></i></a>
                            </h2>
                            <h3 class="text-warning">Summary</h3>
                            <ul class="list-group clear-list m-t">
                                <li class="list-group-item fist-item">
                                    <span class="pull-right">
                                        &nbsp;
                                    </span>
                                    <span class="label label-success">Total Value:</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="pull-right">
                                        ${{ computeTotal("one_time",$hashids->encode($lead->id)) }}
                                    </span>
                                    <span class="label label-primary-darker">Total Value One Time</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="pull-right">
                                        ${{ computeTotal("monthly",$hashids->encode($lead->id)) }}
                                    </span>
                                    <span class="label label-success">Total Value Monthly</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="pull-right">
                                        ${{ computeTotal("annual",$hashids->encode($lead->id)) }}
                                    </span>
                                    <span class="label label-primary-darker">Total Value Annually</span>
                                </li>
                                <li class="list-group-item pull-right">
                                    ${{ computeAnnualized((computeTotal("one-time",$hashids->encode($lead->id))),(computeTotal("monthly",$hashids->encode($lead->id))),(computeTotal("annual",$hashids->encode($lead->id)))) }} annualized
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <h2>&nbsp;</h2>
                            <h3>&nbsp;</h3>
                            <ul class="list-group clear-list m-t">
                                <li class="list-group-item fist-item">
                                <span class="pull-right">
                                    &nbsp;
                                </span>
                                    <span class="label label-success">Expected Value:</span>
                                </li>
                                <li class="list-group-item">
                                <span class="pull-right">
                                    $0
                                </span>
                                    <span class="label label-primary-darker">Total Value Annually</span>
                                </li>
                                <li class="list-group-item">
                                <span class="pull-right">
                                    $0
                                </span>
                                    <span class="label label-success">Total Value Monthly</span>
                                </li>
                                <li class="list-group-item">
                                <span class="pull-right">
                                    $0
                                </span>
                                    <span class="label label-primary-darker">Total Value One time</span>
                                </li>
                                <li class="list-group-item pull-right">
                                    <h2>$0 annualized</h2>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Opportunities under {{ $lead->title }}</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="project-list">
                                @php
                                    $lead_opportunities = DB::table( 'users' )->leftJoin('lead_opportunities','lead_opportunities.user_id','=','users.id')->leftJoin('lead_contacts','lead_contacts.id','=','lead_opportunities.contact_id')->where( 'lead_opportunities.lead_id', $lead->id )->orderBy( 'lead_opportunities.updated_at', 'desc' )->get();
                                @endphp
                                @if($lead_opportunities->count() > 0)
                                    <table class="table table-hover">

                                        <thead>
                                        <tr>
                                            <th>Opportunity User</th>
                                            <th>Value</th>
                                            <th>Value Period</th>
                                            <th>Confidence</th>
                                            <th>Close Date</th>
                                            <th>Status</th>
                                            <th>Contact</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        @foreach($lead_opportunities as $lead_opportunity)
                                            <tr>
                                                <td class="project-title">
                                                    <a class="text-white" href="{{ route('lead.edit',$hashids->encode($lead->id)) }}">
                                                        <h5>{{ $lead_opportunity->name }}</h5></a>
                                                </td>
                                                <td>${{ $lead_opportunity->value }}</td>
                                                <td>{{ $lead_opportunity->value_period }}</td>
                                                <td>
                                                    <small>Confidence with: {{ $lead_opportunity->confidence }}%</small>
                                                    <div class="progress progress-mini">
                                                        <div style="width: {{ $lead_opportunity->confidence }}%;" class="progress-bar"></div>
                                                    </div>
                                                </td>
                                                <td>{{ $lead_opportunity->close_date }}</td>
                                                <td>
                                                    @if($lead_opportunity->status == "active" || $lead_opportunity->status == "won")
                                                        <span class="label label-primary">{{ $lead_opportunity->status }}</span>
                                                    @elseif($lead_opportunity->status == "lost")
                                                        <span class="label label-danger">{{ $lead_opportunity->status }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $lead_opportunity->contact_name }}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                @else
                                    No opportunities available yet,
                                    <a href="{{ route('lead.edit',$hashids->encode($lead->id)) }}">
                                        add now <i class="fa fa-plus"></i> </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="wrapper wrapper-content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="/lead-migrate" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-xs-12">
                    <small>Import bulk leads (.csv)</small>
                    <input type="file" name="file" class="input">
                </div>
                <div class="col-xs-12">
                    <p></p>
                    <input type="submit" value="Import" class="btn btn-primary btn-xs">
                </div>
            </div>
        </form>
    </div>


@endsection
