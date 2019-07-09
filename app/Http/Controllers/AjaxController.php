<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Auth;
use Uuid;

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
  function savePost(Request $request){
  	if(Auth::check()){
  		try{
  			$IDofInsert;
  			if($request->post_id == 0){ //it's a new post, save everything
  				$IDofInsert = DB::table('posts')->insertGetId(
				    ['title' => $request->title, 'content' => $request->content, 'private' => $request->private, 'draft' => $request->draft, 'author_id' => Auth::user()->id, 'updated_at' => date("Y-m-d H:i:s"), 'created_at' => date("Y-m-d H:i:s"), 'private_link' => Uuid::generate()->string]);
  				foreach($request->tags as $value){
  					DB::table('post_tag_xref')->insert(['tag_id' => $value, 'post_id' => $IDofInsert]);
  				}
  			}
  			else{
  				$IDofInsert = $request->post_id;
  				DB::table('posts')->where('id', $request->post_id)->update(
				    ['title' => $request->title, 'content' => $request->content, 'private' => $request->private, 'draft' => $request->draft, 'author_id' => Auth::user()->id, 'updated_at' => date("Y-m-d H:i:s"), 'created_at' => date("Y-m-d H:i:s")]);
  				$currTags = DB::table('post_tag_xref')->where('post_id', $request->post_id)->delete();
  				foreach($request->tags as $value){
  					DB::table('post_tag_xref')->insert(['tag_id' => $value, 'post_id' => $IDofInsert]);
  				} //bad form deleting and remaking the tags every time, but it's just me posting, shouldn't cause issues
  			}
  			return response()->json($IDofInsert);
  		}
			catch(Exception $e){
				return response($e);
			}
  	}
  }
}
