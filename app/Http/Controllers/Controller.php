<?php

namespace App\Http\Controllers;

use App\User;
use Hashids\Hashids;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

	}

	static function getCurrency() {
		return '$';
	}



}
