@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-xs-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title navy-bg">
                    <h2>Total leads: {{ $leads->count() }}</h2>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table style="no-wrap" class="table table-striped table-bordered table-hover db-leads">
                            <thead>
                            <tr>
                                <th>Company</th>
                                <th class="text-center"><i class="fa fa-envelope"></i></th>
                                <th class="text-center"><i class="fa fa-phone"></i></th>
                                <th>Contact</th>
                                <th>Status</th>
                            </tr>
                            </thead>

                            <tbody>
                            @php
                                $leads = DB::table( 'leads' )
                                ->leftJoin('users','leads.user_id','=','users.id')
                                ->leftJoin('lead_contacts','lead_contacts.lead_id','=','leads.id')

                                ->where( 'leads.org_id', $organization->id )
                                ->orderBy( 'leads.updated_at', 'desc' )->get();
                            @endphp
                            @foreach($leads as $lead)
                                @if($lead->contact_name != "")
                                    @php
                                        $contact = DB::table('lead_contacts')->leftJoin('lead_contact_lists','lead_contact_lists.contact_id','=','lead_contacts.id')->where('lead_contacts.lead_id',$lead->id)->first();
                                    @endphp
                                @endif
                                <tr>
                                    <td>{{ $lead->name }}</td>
                                    <td class="text-center"><a href=""><i class="fa fa-envelope"></i></a></td>
                                    <td class="text-center">
                                        @if($lead->contact_name != "")
                                            @if($contact->contact_value == "")
                                                Not Set
                                            @else
                                                <a href=""><i class="fa fa-phone"></i> {{ $contact->contact_value }}</a>
                                            @endif
                                        @endif

                                    </td>
                                    <td class="text-center">
                                        @if($lead->contact_name != "")
                                            {{ $contact->contact_name }}
                                        @endif</td>

                                    <td>{{ $lead->status }}</td>
                                </tr>


                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
