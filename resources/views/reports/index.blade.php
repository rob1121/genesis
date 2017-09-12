@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title navy-bg">
                    <h1>Activity Report</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="row m-l-lg m-t-lg">
                        <h2>Leads</h2>
                        <div class="col-xs-3">
                            <h4>Created</h4>
                            <h1>{{ $leads->count() }}</h1>
                        </div>
                        <div class="col-xs-3">
                            <h4>Lead Contacts</h4>
                            <h1>{{ $total_contacts }}</h1>
                        </div>
                    </div>
                    <div class="row m-l-lg m-t-lg m-b-lg">
                        <h2>Opportunities</h2>
                        <div class="col-xs-3">
                            <h4>Created</h4>
                            <h1>{{ $total_opportunities }}</h1>
                        </div>
                        <div class="col-xs-3">
                            <h4>Active</h4>
                            <h1>{{ $total_active }}</h1>
                        </div>
                        <div class="col-xs-3">
                            <h4>Won</h4>
                            <h1>{{ $total_won }}</h1>
                        </div>
                        <div class="col-xs-3">
                            <h4>Lost</h4>
                            <h1>{{ $total_lost }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
