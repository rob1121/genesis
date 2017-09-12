<?php

namespace App\Http\Controllers;

use App\Lead;
use App\LeadContact;
use App\LeadContactList;
use App\LeadFeed;
use App\User;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class LeadController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		// Validation of inputs
		$this->validate(
			$request, [
				'title' => 'required',
			]
		);

		// Requesting Org Id of User
		$organization = DB::table( 'organizations' )->join( 'organization_roles', 'organizations.id', '=', 'organization_roles.org_id' )->where( 'user_id', Auth::id() )->first();

		$lead              = new Lead();
		$lead->user_id     = Auth::id();
		$lead->org_id      = $organization->id;
		$lead->title       = $request->get( 'title' );
		$lead->description = $request->get( 'description' );
		$lead->url         = $request->get( 'url' );
		$lead->save();

		// Saving created at feed
		$lead_feed          = new LeadFeed();
		$lead_feed->user_id = Auth::id();
		$lead_feed->lead_id = $lead->id;
		$lead_feed->type    = 'initial';
		$lead_feed->value   = "Created lead";
		$lead_feed->save();

		// Hashing newly created lead id
		$hashids = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );

		// Flushing contact on lead contact form
		$request->session()->flash( 'temp_contact', $request->get( 'contact_name' ) );

		return redirect()->route( 'lead.edit', $hashids->encode( $lead->id ) );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$hashids = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );
		$id      = $hashids->decode( $id )[0];

		$user         = User::find( Auth::id() );
		$organization = DB::table( 'organizations' )->join( 'organization_roles', 'organizations.id', '=', 'organization_roles.org_id' )->where( 'user_id', $user->id )->first();
		$lead         = DB::table( 'leads' )->where( 'id', $id )->where( 'org_id', $organization->id )->first();
		// Fetching Lead Users
		$lead_users = DB::table( 'leads' )->join( 'users', 'users.id', '=', 'leads.user_id' )->where( 'leads.id', $lead->id )->orderBy( 'users.updated_at', 'desc' )->get();

		// Fetching Lead
		$lead_feeds = DB::table( 'users' )->join( 'lead_feeds', 'lead_feeds.user_id', '=', 'users.id' )->where( 'lead_id', $lead->id )->orderBy( 'lead_feeds.updated_at', 'desc' )->get();

		// Fetching Tasks
		$lead_tasks = DB::table( 'users' )->join( 'lead_tasks', 'lead_tasks.user_id', '=', 'users.id' )->where( 'lead_id', $lead->id )->orderBy( 'lead_tasks.updated_at', 'desc' )->get();

		// Fetching Opportunities
		$lead_opportunities = DB::table( 'users' )->join( 'lead_opportunities', 'lead_opportunities.user_id', '=', 'users.id' )->where( 'lead_id', $lead->id )->orderBy( 'lead_opportunities.updated_at', 'desc' )->get();

		// Fetching Contacts
		$lead_contacts = DB::table( 'lead_contacts' )->where( 'lead_id', $lead->id )->orderBy( 'lead_contacts.updated_at', 'desc' )->get();

		return view( 'lead.index', compact( 'user', 'organization', 'hashids', 'lead', 'lead_users', 'lead_feeds', 'lead_tasks', 'lead_opportunities', 'lead_contacts', 'lead_contacts_list' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id ) {
		// Updating status of lead
		$hashids          = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );
		$lead_id          = $hashids->decode( $request->get( 'lead_id' ) )[0];
		$lead             = Lead::find( $lead_id );
		$lead_orig_status = $lead->status;
		$lead->status     = $request->get( 'lead_status' );
		$lead->save();

		//Saving Values to Feed
		$user               = User::find( Auth::id() );
		$lead_feed          = new LeadFeed();
		$lead_feed->user_id = $user->id;
		$lead_feed->lead_id = $lead_id;
		$lead_feed->type    = 'status';
		$lead_feed->value   = 'Lead status changed from ' . $lead_orig_status . ' to ' . $lead->status;
		$lead_feed->save();

		return redirect()->route( 'lead.edit', $hashids->encode( $lead_id ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		$hashids = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );
		$lead_id = $hashids->decode( $id );
		Lead::destroy( $lead_id );

		return redirect()->route( 'opportunities.index' );
	}
}
