<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

class FrontController extends Controller {

    public function index() {
        return view('index');
    }
}
