<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LandingController extends Controller
{
 public function index (){
  return view('frontend.landing_page');
 }
 public function landingPageNew (){
  return view('frontend.landing_page_new');

}

}
