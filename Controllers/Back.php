<?php


namespace BeetleCore\Controllers;


use Illuminate\Http\Request;

class Back
{
    public function __invoke(Request $request)
    {
        return view("beetlecore::back", $request->all());
    }
}
