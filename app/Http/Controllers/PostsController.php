<?php

namespace App\Http\Controllers;

use App\Post;
use App\Product;
use App\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(!\Auth::user()->hasRole('admin') && !\Auth::user()->hasRole('manager') && !\Auth::user()->hasRole('editor') ){
            $posts = Product::orderBy('id', 'desc')->get();
        }else{
            $posts = Product::orderBy('id', 'desc')->get();
        }

        return view('admin.posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the field
        $data = request()->validate([
            'title' => 'required|max:255',
            'post_content' => 'required'

        ]);

        $user = auth()->user();
        $post = new Product();

        $post->title = request('title');
        $post->content = request('post_content');
        $post->userId = $user->id;

        $post->save();
        if($request->file('image')) {
            foreach($request->file('image') as $image) {
                
                $fileNameWithTheExtension = $image->getClientOriginalName();
                $fileName = pathinfo($fileNameWithTheExtension, PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $newFileName = $fileName . '_' . time() . '.' . $extension;
                $path = $image->storeAs('public/images/posts_images', $newFileName);

                
                $hosImage = new ProductImage();
                $hosImage->product_id = $post->id;
                $hosImage->image_url = $newFileName;
                $hosImage->save();
            }
        }


        return redirect('/posts')->with('success', 'Post Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $post)
    {
        if (\Request::ajax()){

            $post = Product::find($request['task']['id']);
            $post->published = $request['task']['checked'];
            $post->save();

            return $request;
        }

        return view('admin.posts.show', ['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $post)
    {

        //get the post with the id $post->idate
        $post = Product::find($post->id);

        // return view
        return view('admin/posts/edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $post)
    {
        //validate the field
        $data = request()->validate([
            'title' => 'required|max:255',
            'post_content' => 'required'

        ]);

        if($request->file('image')) {
            foreach($request->file('image') as $image) {
                
                $fileNameWithTheExtension = $image->getClientOriginalName();
                $fileName = pathinfo($fileNameWithTheExtension, PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $newFileName = $fileName . '_' . time() . '.' . $extension;
                $path = $image->storeAs('public/images/posts_images', $newFileName);

                
                $hosImage = new ProductImage();
                $hosImage->product_id = $post->id;
                $hosImage->image_url = $newFileName;
                $hosImage->save();
            }
        }
        // dd($extension);

        $post = Product::findOrFail($post->id);

        $post->title = request('title');
        $post->content = request('post_content');

        $post->save();

        return redirect('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $post, Request $request)
    {
        
        //find the post
        $post = Product::find($request->post_id);
        
        //delete the post
        $post->delete();

        //redirect to posts
        return redirect('/posts');
    }
}
