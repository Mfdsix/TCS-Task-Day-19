<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Mail\SendAdmin;
use App\Exports\BlogsExport;
use Auth;
use Validator;
use Storage;
use Mail;
use Excel;

class AdminController extends Controller
{
	private $user_id = 0;

	public function __construct(){
		$this->middleware(function ($request, $next) {
			$this->user_id = Auth::id();
			return $next($request);
		});
	}

	public function index(Request $request){
		$search = null;
		$limit = 5;

		if($request->has('search')){
			$search = $request->search;
		}

		$blogs = Auth::user()->blogs()->orderBy('created_at', 'DESC')
		->when($search, function($q, $search){
			$q->where('title', 'LIKE', '%'.$search.'%');
		})
		->paginate($limit);
		return view('admin.index', compact('blogs', 'search', 'limit'));
	}

	public function create(){
		$categories = BlogCategory::all();
		return view('admin.create', compact('categories'));
	}

	public function store(Request $request){
		Validator::make($request->all(),[
			'title' => 'required|string|min:4',
			'content' => 'required|string|min:20',
			'category_id' => 'required|string',
			'image' => 'nullable|mimes:jpg,png,jpeg|max:1200',
		])->validate();

		$filename = null;

		if($request->hasFile('image')){
			// file uploading
			// generate random string for name
			$filename = $request->file('image')->store('uploads/blogs');
		}

		Blog::create([
			'title' => $request->title,
			'content' => $request->content,
			'image' => $filename,
			'category_id' => $request->category_id,
			'user_id' => $this->user_id
		]);

		// alternatif for insert data
		// $blog = new Blog();
		// $blog->title = $required->title;
		// $blog->content = $required->content;
		// $blog->image = $required->filename;
		// $blog->user_id = $this->user_id;
		// $blog->save();

		// alternatif query builder, created and updated not inserted (null)
		// $blog = DB::table('blogs')->insert([
		// 	'title' => $request->title,
		// 	'content' => $request->content,
		// 	'image' => $filename,
		// 	'user_id' => $this->user_id
		// ]);

		// send email
		// $users = DB::table('users')->where('role', 'admin')
		// ->select('email')
		// ->get();

		// foreach ($users as $key => $value) {
		// 	Mail::to($value->email)->send(new SendAdmin($request->all()));
		// }

		notify()->success('Blog baru berhasil dibuat');

		// simple notif
		// return redirect('/admin')->with('message', 'Blog Berhasil Ditambahkan');
		return redirect('/admin');
	}

	public function edit($id){
		$blog = Blog::where('user_id', $this->user_id)
		->findOrFail($id);

		$categories = BlogCategory::all();

		// alternatif
		// $blog = DB::table('blogs')->find($id);

		return view('admin.edit', compact('blog', 'categories'));
	}

	public function update($id, Request $request){
		$blog = Blog::where('user_id', $this->user_id)
		->findOrFail($id);

		Validator::make($request->all(),[
			'title' => 'required|string|min:4',
			'content' => 'required|string|min:20',
			'category_id' => 'required|string',
			'image' => 'nullable|mimes:jpg,png,jpeg|max:1200',
		])->validate();

		$filename = $blog->image;

		if($request->hasFile('image')){
			// file uploading
			if($blog->image != null){
				Storage::delete($filename);
			}
			$filename = $request->file('image')->store('uploads/blogs');
		}

		$blog->update([
			'title' => $request->title,
			'content' => $request->content,
			'image' => $filename,
			'category_id' => $request->category_id,
			'user_id' => $this->user_id
		]);

		// alternatif
		// $blog->title = $request->title;
		// $blog->content = $request->content;
		// $blog->image = $filename;
		// $blog->user_id = $this->user_id;
		// $blog->save();

		// alternatif query builder
		// $blog = DB::table('blogs')
		// ->where('id', $id)
		// ->update([
		// 	'title' => $request->title,
		// 	'content' => $request->content,
		// 	'image' => $filename,
		// 	'user_id' => $this->user_id
		// ]);

		notify()->success('Blog berhasil diedit');
		// emotify('success', 'Blog berhasil diedit');
		// smilify('success', 'Blog berhasil diedit');
		// drakify('success');
		// connectify('success', 'Connection Found', 'Success Message Here');

		return redirect('/admin');
	}

	public function delete($id){
		$blog = Blog::where('user_id', $this->user_id)
		->findOrFail($id);

		// alternatif query builder
		// $blog = DB::table('blogs')
		// ->where('id', $id)
		// ->first();

		if($blog->image != null){
			Storage::delete($blog->image);
		}
		$blog->delete();

		// alternative query builder
		// $blog = DB::table('blogs')
		// ->where('id', $id)
		// ->delete();
		notify()->success('Blog berhasil dihapus');

		return redirect('/admin');
	}

	public function export(){
		return Excel::download(new BlogsExport, 'blogs.xlsx');
	}
}
