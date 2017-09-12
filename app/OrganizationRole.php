<?php

namespace App;

use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;

class OrganizationRole extends Model
{
	protected $fillable = ['org_id','user_id','role'];
}
