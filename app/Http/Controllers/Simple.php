<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Simple extends Controller
{
	public function index()
	{
		$fakeData = [
			'email' => 'andikodwi',
			'password' => 'andikodwi@gmail.com'
		];

		return response() ->json($fakeData);
	}
}