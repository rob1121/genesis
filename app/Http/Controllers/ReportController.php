<?php

namespace App\Http\Controllers;

use App\Lead;
use App\LeadOpportunity;
use App\User;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$hashids      = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );
		$user         = User::find( Auth::id() );
		$organization = DB::table( 'organizations' )->join( 'organization_roles', 'organizations.id', '=', 'organization_roles.org_id' )->where( 'user_id', $user->id )->first();
		$leads        = Lead::all()->where( 'org_id', $organization->id );

		$total_contacts      = 0;
		$total_active        = 0;
		$total_won           = 0;
		$total_lost          = 0;
		$total_opportunities = 0;

		foreach ( $leads as $lead ) {
			$total_opportunities += intval( DB::table( 'leads' )->leftJoin( 'lead_opportunities', 'lead_opportunities.lead_id', '=', 'leads.id' )->where( 'lead_opportunities.lead_id', $lead->id )->get()->count() );
			$total_contacts      += intval( DB::table( 'leads' )->leftJoin( 'lead_contacts', 'lead_contacts.lead_id', '=', 'leads.id' )->where( 'lead_contacts.lead_id', $lead->id )->get()->count() );
			$total_active        += intval( DB::table( 'leads' )->leftJoin( 'lead_opportunities', 'lead_opportunities.lead_id', '=', 'leads.id' )->where( 'lead_opportunities.lead_id', $lead->id )->where( 'lead_opportunities.status', 'active' )->get()->count() );
			$total_won           += intval( DB::table( 'leads' )->leftJoin( 'lead_opportunities', 'lead_opportunities.lead_id', '=', 'leads.id' )->where( 'lead_opportunities.lead_id', $lead->id )->where( 'lead_opportunities.status', 'won' )->get()->count() );
			$total_lost          += intval( DB::table( 'leads' )->leftJoin( 'lead_opportunities', 'lead_opportunities.lead_id', '=', 'leads.id' )->where( 'lead_opportunities.lead_id', $lead->id )->where( 'lead_opportunities.status', 'lost' )->get()->count() );
		}


		return view( 'reports.index', compact( 'leads', 'organization', 'user', 'hashids','total_contacts','total_active','total_won','total_lost','total_opportunities' ) );
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
		//
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
