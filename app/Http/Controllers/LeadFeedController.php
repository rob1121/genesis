<?php

namespace App\Http\Controllers;

use App\Lead;
use App\LeadFeed;
use App\User;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadFeedController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		//
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
				'feed_value'        => 'required',
			]
		);

		$hashids = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );

		$user               = User::find( Auth::id() );
		$lead_feed          = new LeadFeed();
		$lead_feed->user_id = $user->id;
		$lead_feed->lead_id = $hashids->decode( $request->get( 'lead_feed_id' ) )[0];
		$lead_feed->type    = $request->get( 'feed_type' );
		$lead_feed->value   = $request->get( 'feed_value' );
		$lead_feed->save();

		return redirect()->route( 'lead.edit', $hashids->encode( $lead_feed->lead_id ) );
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
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int                      $id
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id ) {
		// Validation of inputs
		$this->validate(
			$request, [
				'feed_value_update'        => 'required',
			]
		);


		$hashids = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );
		$feed_id = $hashids->decode( $request->get( 'feed_id' ) )[0];

		$lead_feeds        = LeadFeed::find( $feed_id );
		$lead_feeds->value = $request->get( 'feed_value_update' );
		$lead_feeds->save();

		return redirect()->route( 'lead.edit', $hashids->encode( $lead_feeds->lead_id ) );
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
		$feed_id = $hashids->decode( $id )[0];
		$feed    = LeadFeed::find( $feed_id );
		$lead_id = $feed->lead_id;
		LeadFeed::destroy( $feed_id );

		return redirect()->route( 'lead.edit', $hashids->encode( $lead_id ) );
	}


}
