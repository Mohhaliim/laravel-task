<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListMailController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        return view('sadmin.list_mail.index');
    }
}
