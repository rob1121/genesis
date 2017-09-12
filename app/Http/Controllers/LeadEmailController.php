<?php

namespace App\Http\Controllers;

use App\LeadEmail;
use App\LeadFeed;
use App\User;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadEmailController extends Controller {
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
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$hashids = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );

		// Getting Instance of Logged In User
		$user = User::find( Auth::id() );

		// Saving Email on Feed
		$lead_feed          = new LeadFeed();
		$lead_feed->user_id = $user->id;
		$lead_feed->lead_id = $hashids->decode( $request->get( 'lead_feed_id' ) )[0];
		$lead_feed->type    = 'email';
		$lead_feed->value   = '';
		$lead_feed->save();

		// Saving on Email Thread
		$email          = new LeadEmail();
		$receiver_array = $request->get( 'email_receiver' );
		$receiver       = implode( ', ', $receiver_array );

		$email->feed_id  = $lead_feed->id;
		$email->receiver = $receiver;
		$email->sender   = $user->email;
		$email->message  = $request->get( 'email_message' );
		$email->save();


		foreach ( $receiver_array as $receiver ) {
			mail( $receiver, "Message from checkit solutions", $request->get( 'email_message' ) );
		}


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
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id ) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		//
	}
}
