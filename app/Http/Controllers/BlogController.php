<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Date;

class BlogController extends Controller
{
  function profile(){
  if(Auth::check()){
  	return view('profile');
  }
  return view('welcome');
  }
  function landing(){
  	$firstPost = DB::table('posts')
  	->join('users', 'posts.author_id', '=', 'users.id')
  	->select('posts.*', 'users.name')
  	->where('pinned', 1)
  	->where('draft', 0)
  	->where('private', 0)
  	->first();
  	$last4 = DB::table('posts')
  	->join('users', 'posts.author_id', '=', 'users.id')
  	->select('posts.*', 'users.name')
  	->where('pinned', 0)
  	->where('draft', 0)
  	->where('private', 0)
  	->orderBy('posts.created_at', 'desc')
  	->limit(4)
  	->get();
  	$applicableTags = DB::table('post_tag_xref')
  	->join('tags', 'tags.id', '=', 'post_tag_xref.tag_id')
  	->get();
  	return view('welcome')
  	->with('firstPost', $firstPost)
  	->with('last4', $last4)
  	->with('tags', $applicableTags);
  }
  function blogSettings(){
  	return view('blogSettings');
  }
  function newPost(){
  	if(Auth::check()){
  		return view('newPost');
  	}
  	else{
  		return redirect('/');
  	}
  }
  function viewPost($id){
  	// $postInfo = DB::table('posts')
  	// ->join('users', 'posts.author_id', '=', 'users.id')
  	// ->where('posts.id', $id)
  	// ->orWhere('private_link', $id)
  	// ->where('draft', 0)
  	// ->select('posts.*', 'users.name')
  	// ->first();
  	$postInfo = DB::table('posts')
  	->join('users', 'posts.author_id', '=', 'users.id')
  	->where('posts.id', $id)
  	->where('draft', 0)
  	->where('private', 1)
  	->select('posts.*', 'users.name')
  	->first();
  	if(is_null($postInfo)){
  		$publicPost = DB::table('posts')
  		->join('users', 'posts.author_id', '=', 'users.id')
  		->where('posts.id', $id)
  		->where('draft', 0)
  		->select('posts.*', 'users.name')
  		->first();
  		$date = date('F jS Y', strtotime($publicPost->created_at));
	  	return view('viewPost')
	  	->with('postInfo', $publicPost)
	  	->with('date', $date);
  	}
  	if(is_null($postInfo)){
  		return redirect('/');
  	}
  	$date = date('F jS Y', strtotime($postInfo
  		->created_at));
  	return view('viewPost')
  	->with('postInfo', $postInfo)
  	->with('date', $date);
  }
  function allPosts(){
  	$firstPost = DB::table('posts')
  	->join('users', 'posts.author_id', '=', 'users.id')
  	->select('posts.*', 'users.name')
  	->where('pinned', 1)
  	->where('draft', 0)
  	->where('private', 0)
  	->get();
  	$last4 = DB::table('posts')
  	->join('users', 'posts.author_id', '=', 'users.id')
  	->select('posts.*', 'users.name')
  	->where('pinned', 0)
  	->where('draft', 0)
  	->where('private', 0)
  	->orderBy('posts.created_at', 'desc')
  	->get();
  	$applicableTags = DB::table('post_tag_xref')
  	->join('tags', 'tags.id', '=', 'post_tag_xref.tag_id')
  	->get();
  	return view('allPosts')
  	->with('pinnedPosts', $firstPost)
  	->with('last4', $last4)
  	->with('tags', $applicableTags);
  }

}

