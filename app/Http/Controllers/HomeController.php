<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $data['title'] = _trans('common.Home');
        return redirect()->route('adminLogin');
    }
}
