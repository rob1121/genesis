<?php

namespace App\Http\Controllers;

use App\LeadOpportunity;
use App\User;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadOpportunityController extends Controller {
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
		// Validation of inputs
		$this->validate(
			$request, [
				'opportunity_value' => 'required',
			]
		);

		$hashids = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );

		$lead_opportunity               = new LeadOpportunity();
		$lead_opportunity->lead_id      = $hashids->decode( $request->get( 'lead_opportunity_id' ) )[0];
		$lead_opportunity->status       = $request->get( 'opportunity_status' );
		$lead_opportunity->confidence   = $request->get( 'opportunity_confidence' );
		$lead_opportunity->value        = $request->get( 'opportunity_value' );
		$lead_opportunity->value_period = $request->get( 'opportunity_value_period' );
		$lead_opportunity->close_date   = Carbon::parse( $request->get( 'opportunity_close_date' ) )->format( 'Y-m-d' );
		$lead_opportunity->comments     = $request->get( 'opportunity_comments' );
		$lead_opportunity->user_id      = $request->get( 'opportunity_uid' );
		$lead_opportunity->contact_id   = $request->get( 'opportunity_cid' );
		$lead_opportunity->save();

		return redirect()->route( 'lead.edit', $hashids->encode( $lead_opportunity->lead_id ) );
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
		// Validation of inputs
		$this->validate(
			$request, [
				'opportunity_value_update' => 'required',
			]
		);

		$hashids                        = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );
		$opportunity_id                 = $hashids->decode( $request->get( 'opportunity_id' ) )[0];

		$lead_opportunity               = LeadOpportunity::find( $opportunity_id );
		$lead_opportunity->status       = $request->get( 'opportunity_status_update' );
		$lead_opportunity->confidence   = $request->get( 'opportunity_confidence_update' );
		$lead_opportunity->value        = $request->get( 'opportunity_value_update' );
		$lead_opportunity->value_period = $request->get( 'opportunity_value_period_update' );
		$lead_opportunity->close_date   = Carbon::parse( $request->get( 'opportunity_close_date_update' ) )->format( 'Y-m-d' );
		$lead_opportunity->comments     = $request->get( 'opportunity_comment_update' );
		$lead_opportunity->user_id      = $request->get( 'opportunity_uid_update' );
		$lead_opportunity->contact_id   = $request->get( 'opportunity_cid_update' );
		$lead_opportunity->save();
		//
		return redirect()->route( 'lead.edit', $hashids->encode( $lead_opportunity->lead_id ) );
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
		$opportunity_id = $hashids->decode( $id )[0];
		$opportunity    = LeadOpportunity::find( $opportunity_id);
		$lead_id = $opportunity->lead_id;
		LeadOpportunity::destroy( $opportunity_id );

		return redirect()->route( 'lead.edit', $hashids->encode( $lead_id ) );
	}
}
