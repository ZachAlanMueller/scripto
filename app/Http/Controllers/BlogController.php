<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class BlogController extends Controller
{
  function profile(){
  if(Auth::check()){
  	return view('profile');
  }
  return view('welcome');
  }
  function landing(){
  	return view('welcome');
  }
  function blogSettings(){
  	return view('blogSettings');
  }
}
