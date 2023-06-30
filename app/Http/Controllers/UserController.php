<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function getUser(Request $request)
	{
		return ['user'  => UserResource::make($request->user())];
	}
}
