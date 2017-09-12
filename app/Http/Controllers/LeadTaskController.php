<?php

namespace App\Http\Controllers;

use App\LeadTask;
use App\User;
use Carbon\Carbon;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadTaskController extends Controller {
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
				'task_message' => 'required',
			]
		);

		$hashids = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );

		$user               = User::find( Auth::id() );
		$lead_task          = new LeadTask();
		$lead_task->user_id = $user->id;
		$lead_task->lead_id = $hashids->decode( $request->get( 'lead_task_id' ) )[0];
		$lead_task->message = $request->get( 'task_message' );
		$lead_task->date    = Carbon::parse( $request->get( 'task_date' ) )->format( 'Y-m-d' );
		$lead_task->time    = $request->get( 'task_time' );
		$lead_task->status  = 'unfinished';
		$lead_task->save();

		return redirect()->route( 'lead.edit', $hashids->encode( $lead_task->lead_id ) );
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
				'task_message_update' => 'required',
			]
		);

		$hashids = new Hashids( '', 30, '!@#$%^&*()1234567890ABCDEFGHIJKMNOPabcdefghijklmnopqrstuvwxyz' );
		$task_id = $hashids->decode( $request->get( 'task_id' ) )[0];

		$lead_task          = LeadTask::find( $task_id );
		$lead_task->message = $request->get( 'task_message_update' );
		$lead_task->date    = Carbon::parse( $request->get( 'task_date_update' ) )->format( 'Y-m-d' );
		$lead_task->time    = $request->get( 'task_time_update' );
		$lead_task->status  = 'unfinished';
		$lead_task->save();

		return redirect()->route( 'lead.edit', $hashids->encode( $lead_task->lead_id ) );
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
		$task_id = $hashids->decode( $id )[0];
		$task    = LeadTask::find( $task_id );
		$lead_id = $task->lead_id;
		LeadTask::destroy( $task_id );

		return redirect()->route( 'lead.edit', $hashids->encode( $lead_id ) );
	}
}
