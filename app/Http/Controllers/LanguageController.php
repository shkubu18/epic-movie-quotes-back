<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
	public function setLocale(string $language): JsonResponse
	{
		App::setLocale($language);
		Session::put('locale', $language);

		return response()->json(['message' => 'locale changed successfully', 'locale' => App::getLocale()]);
	}
}
