<?php

use Hashids\Hashids;
use Illuminate\Support\Facades\DB;

function computeTotal( $value_period, $lead_id ) {
	$total = 0;

	$hashids = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );
	$lead_id = $hashids->decode( $lead_id );

	foreach ( DB::table( 'lead_opportunities' )->leftJoin( 'users', 'users.id', '=', 'lead_opportunities.user_id' )->leftJoin( 'lead_contacts', 'lead_contacts.id', '=', 'lead_opportunities.contact_id' )->where( 'lead_opportunities.lead_id', $lead_id )->where( 'lead_opportunities.value_period', $value_period )->orderBy( 'lead_opportunities.updated_at', 'desc' )->get() as $lead_opportunity ) {
		$total += $lead_opportunity->value;
	}

	if ( $value_period == "monthly" ) {
		$total *= 12;
	}

	return $total;
}

function computeAnnualized( $total_one_time, $total_monthly, $total_annual ) {
	$total = $total_one_time + ( $total_monthly * 12 ) + $total_annual;

	return $total;
}


function getContactEmail( $contact_id ) {
	$test_contact = DB::table( 'lead_contact_lists' )->where( 'contact_id', $contact_id )->where( 'contact_type', 'email' )->get();
	if($test_contact->count() == 0) return false;

	$contact_email = DB::table( 'lead_contact_lists' )->where( 'contact_id', $contact_id )->where( 'contact_type', 'email' )->first();
	return $contact_email->contact_value;
}

function getThreadEmails($feed_id){
	$emails = DB::table('lead_emails')->where('feed_id',$feed_id)->get();
	return $emails;
}