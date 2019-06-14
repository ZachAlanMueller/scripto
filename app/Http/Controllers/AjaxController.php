<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Auth;

class AjaxController extends Controller
{
  function updateUser(Request $request){
  	if(Auth::check()){
  		try{
  			$user = Auth::user();
		    if($request->name != ''){
		    	$user->name = $request->name;
		    }
		    if($request->email != ''){
		      $user->email = $request->email;
		    }
		    if($request->password != ''){
		      $user->password = bcrypt($request->password);
		    }
		    $user->save();
		    return response()->json($request);
  		}
			catch(Exception $e){
				return response($e);
			}
  	}
  }
  function getTags(Request $request){
  	if(Auth::check()){
  		try{
  			$returnVal = DB::table('tags')->get();
  			return response()->json($returnVal);
  		}
			catch(Exception $e){
				return response($e);
			}
  	}
  }
  function addTag(Request $request){
  	if(Auth::check()){
  		try{
  			DB::table('tags')->insert([
			    ['name' => $request->name, 'color' => $request->color]
				]);
  			return response()->json('Success');
  		}
			catch(Exception $e){
				return response($e);
			}
  	}
  }
}
