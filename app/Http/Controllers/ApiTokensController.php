<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiTokensController extends Controller
{
    public function index()
    {
        return view('tokens.index');
    }
}
