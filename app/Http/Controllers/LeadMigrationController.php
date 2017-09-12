<?php

namespace App\Http\Controllers;

use App\Lead;
use App\LeadFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Excel;

class LeadMigrationController extends Controller
{
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
        echo "uploaded";
        // Validation of inputs
        $this->validate(
            $request, [
                'file' => 'required|file|mimes:csv,txt',
            ]
        );
        $data = $request->file('file')->store('csv');

        \Excel::load(storage_path("app\\" . $data), function($reader) {
            // Getting all results
            collect($reader->all())->map(function($newLead) {

                if (
                    $newLead->user_id !== null &&
                    $newLead->title !== null &&
                    $newLead->description !== null &&
                    $newLead->url !== null)
                {

                    // Requesting Org Id of User
                    $organization = DB::table( 'organizations' )->join( 'organization_roles', 'organizations.id', '=', 'organization_roles.org_id' )
                        ->where( 'user_id', $newLead->user_id )
                        ->first();

                    $lead              = new Lead();
                    $lead->user_id     = $newLead->user_id;
                    $lead->org_id      = $organization->id;
                    $lead->title       = $newLead->title;
                    $lead->description = $newLead->description;
                    $lead->url         = $newLead->url;
                    $lead->save();

                    // Saving created at feed
                    $lead_feed          = new LeadFeed();
                    $lead_feed->user_id = $newLead->user_id;
                    $lead_feed->lead_id = $lead->id;
                    $lead_feed->type    = 'initial';
                    $lead_feed->value   = "Created lead";
                    $lead_feed->save();

                }
            });
        });
        $request->session()->flash('success', 'leads successfully added');
        return back();
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