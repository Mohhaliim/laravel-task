<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListMailController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        /* $emails = EmailSubscription::pluck('email','email')->toArray(); */


        return view('sadmin.list_mail.index');
    }
}
