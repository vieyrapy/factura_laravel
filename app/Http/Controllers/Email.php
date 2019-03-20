<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Email extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('emails.comprobante');
    }

    public function __invoke(Request $request)
    {
        //
    }


}
