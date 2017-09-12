<?php

namespace App\Http\Controllers;

use App\LeadContactList;
use Hashids\Hashids;
use Illuminate\Http\Request;

class LeadContactListController extends Controller {
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

		$hashids                          = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );
		$contact_id                       = $hashids->decode( $request->get( 'parent_contact_id' ) )[0];
		$lead_contact_list                = new LeadContactList();
		$lead_contact_list->lead_id       = $hashids->decode( $request->get( 'lead_contact_id' ) )[0];
		$lead_contact_list->contact_id    = $contact_id;
    $lead_contact_list->contact_type  = $request->get( 'contact_list_type' );
    $lead_contact_list->contact_value = $request->get( 'contact_list_value' );
		$lead_contact_list->save();

		return redirect()->route( 'lead.edit', $hashids->encode( $lead_contact_list->lead_id ) );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {

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
		$hashids    = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );
		$contact_list_id = $hashids->decode( $id )[0];
		$contact_list    = LeadContactList::find( $contact_list_id );
		$lead_id    = $contact_list->lead_id;
		LeadContactList::destroy( $contact_list_id );

		return redirect()->route( 'lead.edit', $hashids->encode( $lead_id ) );
	}
}
