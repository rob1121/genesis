<?php

namespace App\Http\Controllers;

use App\LeadContact;
use App\User;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadContactController extends Controller {
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
				'contact_name'   => 'required',
				'contact_title'  => 'required',
			]
		);

		$hashids = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );


		$lead_contact                 = new LeadContact();
		$lead_contact->lead_id        = $hashids->decode( $request->get( 'lead_contact_id' ) )[0];
		$lead_contact->contact_name   = $request->get( 'contact_name' );
		$lead_contact->contact_title  = $request->get( 'contact_title' );
		$lead_contact->save();

		return redirect()->route( 'lead.edit', $hashids->encode( $lead_contact->lead_id ) );
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
				'contact_name_update'  => 'required',
				'contact_title_update' => 'required',
			]
		);

		$hashids                     = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );
		$contact_id                  = $hashids->decode( $request->get( 'contact_id' ) )[0];
		$lead_contact                = LeadContact::find( $contact_id );
		$lead_contact->contact_name  = $request->get( 'contact_name_update' );
		$lead_contact->contact_title = $request->get( 'contact_title_update' );
		$lead_contact->save();

		return redirect()->route( 'lead.edit', $hashids->encode( $lead_contact->lead_id ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		$hashids    = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );
		$contact_id = $hashids->decode( $id )[0];
		$contact    = LeadContact::find( $contact_id );
		$lead_id    = $contact->lead_id;
		LeadContact::destroy( $contact_id );

		return redirect()->route( 'lead.edit', $hashids->encode( $lead_id ) );
	}
}
