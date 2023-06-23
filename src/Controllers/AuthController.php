<?php

namespace BeetleCore\Controllers;

class AuthController extends Controller
{
    public function exit() {
        request()->session()->flush();
        return redirect()->route("admin.index");
    }
}
