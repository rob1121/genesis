<?php

namespace App;

use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
	protected $fillable = ['name'];
}
