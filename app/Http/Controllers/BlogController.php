<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\User;

class BlogController extends Controller
{
	public function index(Request $request){
		$search = null;
		$limit = 6;

		if($request->has('search')){
			$search = $request->search;
		}

		$blogs = Blog::orderBy('created_at', 'DESC')
		->when($search, function($q, $search){
			$q->where('title', 'LIKE', '%'.$search.'%');
		})
		->paginate($limit);

		return view('blog.index', compact('blogs', 'search', 'limit'));
	}

	public function show($id){
		$blog = Blog::findOrFail($id);
		$blogs = Blog::where('id', '!=', $id)
		->orderBy('created_at', 'DESC')
		->limit(3)
		->get();

		return view('blog.show', compact('blog', 'blogs'));
	}

	public function author($id, Request $request){
		$author = User::findOrFail($id);

		$search = null;
		$limit = 6;

		if($request->has('search')){
			$search = $request->search;
		}

		$blogs = Blog::orderBy('created_at', 'DESC')
		->where('user_id', $id)
		->when($search, function($q, $search){
			$q->where('title', 'LIKE', '%'.$search.'%');
		})
		->paginate($limit);

		return view('blog.author', compact('blogs', 'search', 'limit', 'author'));
	}
}
