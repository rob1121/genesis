<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Hashids\Hashids;

Route::get(
	'/', function () {
	return view( 'welcome' );
}
);

Auth::routes();

Route::resource( 'opportunities', 'HomeController' );
Route::resource( 'lead-migrate', 'LeadMigrationController' );
Route::resource( 'lead', 'LeadController' );
Route::resource( 'lead-details', 'LeadDetailsController' );
Route::resource( 'lead-feed', 'LeadFeedController' );
Route::resource( 'lead-task', 'LeadTaskController' );
Route::resource( 'lead-opportunity', 'LeadOpportunityController' );
Route::resource( 'lead-contact', 'LeadContactController' );
Route::resource( 'lead-contact-list', 'LeadContactListController' );
Route::resource( 'lead-email', 'LeadEmailController' );
Route::resource( 'reports', 'ReportController' );
Route::resource( 'leads', 'LeadsController' );
