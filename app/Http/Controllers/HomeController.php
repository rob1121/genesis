<?php

namespace App\Http\Controllers;

use App\Lead;
use App\Organization;
use App\User;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware( 'auth' );
	}


	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$hashids       = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );
		$user          = User::find( Auth::id() );
		$organization  = DB::table( 'organizations' )->join( 'organization_roles', 'organizations.id', '=', 'organization_roles.org_id' )->where( 'user_id', $user->id )->first();
		$leads         = Lead::all()->where( 'org_id', $organization->id );
		$opportunities = DB::table( 'lead_opportunities' )->join( 'leads', 'leads.id', '=', 'lead_opportunities.lead_id' )->where( 'leads.org_id', $organization->id )->get();
		$users = DB::table( 'organizations' )->join( 'organization_roles', 'organizations.id', '=', 'organization_roles.org_id' )->leftJoin('users','users.id','=','organization_roles.user_id')->where( 'organizations.id', $organization->id )->get();



		// Computation for Total Value
		$total_one_time   = 0;
		$total_monthly    = 0;
		$total_annual     = 0;
		$total_annualized = 0;
		foreach ( $opportunities as $opportunity ) {
			if ( $opportunity->value_period == "one_time" ) {
				$total_one_time += intval( $opportunity->value );
			} else if ( $opportunity->value_period == "monthly" ) {
				$total_monthly += intval( $opportunity->value ) * 12;
			} else if ( $opportunity->value_period == "annual" ) {
				$total_annual += intval( $opportunity->value );
			}
		}

		$total_annualized = $total_one_time + $total_monthly + $total_annual;


		return view( 'opportunities.index', compact( 'user', 'organization','users', 'leads', 'opportunities', 'hashids', 'total_one_time', 'total_monthly', 'total_annual', 'total_annualized' ) );
	}
}

